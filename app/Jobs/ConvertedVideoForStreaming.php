<?php

namespace App\Jobs;

use App\Models\ConvertedVideos;
use App\Models\Video;
use FFMpeg\Coordinate\Dimension;
use FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Format\Video\X264;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ConvertedVideoForStreaming implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $video;
    public $format;
    public $VideoWidth;
    public $VideoHeight;
    public $names;
    public $i ;
    
    public function __construct(Video $video)
    {
        $this->video = $video;
    }
    protected function convertVideo($loopnumber){
        $this->format = array(
            array(
                (new X264('aac' , 'libx264'))->setKiloBitrate(4096) , (new WebM('libvorbis', 'libvpx'))->setKiloBitrate(4096)
            ),
            array(
                (new X264('aac' , 'libx264'))->setKiloBitrate(2048) , (new WebM('libvorbis', 'libvpx'))->setKiloBitrate(2048)
            ),
            array(
                (new X264('aac' , 'libx264'))->setKiloBitrate(750) , (new WebM('libvorbis', 'libvpx'))->setKiloBitrate(750)
            ),
            array(
                (new X264('aac' , 'libx264'))->setKiloBitrate(500) , (new WebM('libvorbis', 'libvpx'))->setKiloBitrate(500)
            ),
            array(
                (new X264('aac' , 'libx264'))->setKiloBitrate(300) , (new WebM('libvorbis', 'libvpx'))->setKiloBitrate(300)
            ),

        );
        $this->VideoWidth = [1920 , 1280 , 854,640 ,426];
        $this->VideoHeight = [1080 , 720 , 480,360 ,240];
        $this->names = [
            array('1080p-' . $this->getFileName($this->video->video_path , '.mp4') , '1080p-' . $this->getFileName($this->video->video_path , '.webm')),
            array('720p-' . $this->getFileName($this->video->video_path , '.mp4') , '720p-' . $this->getFileName($this->video->video_path , '.webm')),
            array('480p-' . $this->getFileName($this->video->video_path , '.mp4') , '480p-' . $this->getFileName($this->video->video_path , '.webm')),
            array('360p-' . $this->getFileName($this->video->video_path , '.mp4') , '360p-' . $this->getFileName($this->video->video_path , '.webm')),
            array('240p-' . $this->getFileName($this->video->video_path , '.mp4') , '240p-' . $this->getFileName($this->video->video_path , '.webm')),
        ];

        for ($this->i = $loopnumber; $this->i < 5; $this->i++) { 
            for ($j=0; $j < 2; $j++) { 
                FFMpeg::fromDisk($this->video->disk)
                    ->open($this->video->video_path)
                    ->export()
                    ->toDisk(env('FILESYSTEM_DISK'))
                    ->inFormat($this->format[$this->i][$j])
                    ->addFilter(function (VideoFilters $filters){
                        $filters->resize(new Dimension($this->VideoWidth[$this->i] , $this->VideoHeight[$this->i]));
                    })
                    ->save($this->names[$this->i][$j]);
            }
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ffprobe = FFMpeg\FFProbe::create();
        $video1 = $ffprobe->streams(public_path('/storage//' . $this->video->video_path))->videos()->first();
        $width = $video1->get('width');
        $height = $video1->get('height');

        $media = FFMpeg::fromDisk($this->video->disk)->open($this->video->video_path);
        $durationInSeconds = $media->getDurationInSeconds();
        $hours = floor($durationInSeconds / 3600);
        $minutes = floor(($durationInSeconds / 60) % 60);
        $seconds = $durationInSeconds % 60;
        $quality = 0 ;

        if($width > $height){
            if(($width >= 1920) && ($height >= 1080)){
                $quality = 1080;
                $this->convertVideo(0);
            }
            elseif(($width >= 1280) && ($height >= 720) && ($width < 1920 && $height < 1080)){
                $quality = 720;
                $this->convertVideo(1);
            }
            elseif(($width >= 854) && ($height >= 480) && ($width < 1280 && $height < 720)){
                $quality = 480;
                $this->convertVideo(2);
            }
            elseif(($width >= 640) && ($height >= 360) && ($width < 854 && $height < 480)){
                $quality = 360;
                $this->convertVideo(3);
            }
            else {
                $quality = 240;
                $this->convertVideo(4);
            }

        }
        elseif($height > $width){
            $this->video->update([
                'longi' => true]);
            if(($height >= 1920) && ($width >= 1080)){
                $quality = 1080;
                $this->convertVideo(0);
            }
            elseif(($height >= 1280) && ($width >= 720) && ($height < 1920 && $width < 1080)){
                $quality = 720;
                $this->convertVideo(1);
            }
            elseif(($height >= 854) && ($width >= 480) && ($height < 1280 && $width < 720)){
                $quality = 480;
                $this->convertVideo(2);
            }
            elseif(($height >= 640) && ($width >= 360) && ($height < 854 && $width < 480)){
                $quality = 360;
                $this->convertVideo(3);
            }
            else {
                $quality = 240;
                $this->convertVideo(4);
            }
        }
        Storage::disk('public')->delete($this->video->video_path);

        $convertedVideo = new ConvertedVideos;
        for($this->i = 0; $this->i < 5; $this->i++ ){
            $convertedVideo->{'mp4_Format_' . $this->VideoHeight[$this->i]} = $this->names[$this->i][0];
            $convertedVideo->{'webm_Format_' . $this->VideoHeight[$this->i]} = $this->names[$this->i][1];
        } 
        $convertedVideo->video_id = $this->video->id;
        $convertedVideo->save();
        $this->video->update([
            'processed' => true,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds , 
            'quality' => $quality
        ]);
    }
    private function getFileName($filename , $type){
        return preg_replace('/\\.[^.\\s]{3,4}$/' , '' , $filename) . $type ; 
    }
}
