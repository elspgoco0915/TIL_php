<?php
declare(strict_types=1);

/**
 * Facade を、 複雑なサブシステムに対する単純化アダプターと考えてみてください。 Facade は、 複雑さを一つのクラスに隔離することにより、 アプリケーション・コードが分かりやすいインターフェースを使えるようにします。
 * この例では、 ファサードが、 YoutTube API と FFmpeg ライブラリーの複雑さをクライアント・コードから隔離します。 数十ものクラスと関わる代わりに、 クライアントはファサード上の単純なメソッド一つを使用します。
 */
namespace RefactoringGuru\Facade\RealWorld;

/**
 * Facadeはyoutubeからビデオをダウンロードするための単一のメソッドを提供する
 * このメソッドで、youtubeAPI, ビデオ変換ライブラリ、PHPのネットワークレイヤーなどの複雑さをすべて隠します。
 */
class YoutubeDownloader
{
    protected $youtube;
    protected $ffmpeg;

    /**
     * Facadeが使用するサブシステムのライフサイクルを管理できると便利
     */
    public function __construct(string $youtubeApikey)
    {
        $this->youtube = new Youtube($youtubeApikey);
        $this->ffmpeg = new FFMpeg();
    }

    /**
     * Facadeはビデオをダウンロードして指定した形式にエンコードする処理を提供
     * （簡素化するため、実際のコードはコメントアウトされています）
     */
    public function downloadVideo(string $url): void
    {
        echo "Fetching video metadata from youtube...\n";
        // $title = $this->youtube->fetchVideo($url)->getTitle();
        echo "Saving video file to a temporary file...\n";
        // $this->youtube->saveAs($url, "video.mpg");

        echo "Processing source video...\n";
        // $video = $this->ffmpeg->open('video.mpg');
        echo "Normalizing and resizing the video to smaller dimensions...\n";
        // $video
        //     ->filters()
        //     ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
        //     ->synchronize();
        echo "Capturing preview image...\n";
        // $video
        //     ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
        //     ->save($title . 'frame.jpg');
        echo "Saving video in target formats...\n";
        // $video
        //     ->save(new FFMpeg\Format\Video\X264(), $title . '.mp4')
        //     ->save(new FFMpeg\Format\Video\WMV(), $title . '.wmv')
        //     ->save(new FFMpeg\Format\Video\WebM(), $title . '.webm');
        echo "Done!\n";
    }
}


/**
 * The YouTube API subsystem.
 */
class YouTube
{
    public function fetchVideo(): string { /* ... */ }

    public function saveAs(string $path): void { /* ... */ }

    // ...そのほか大量のメソッドやクラスなど
}

/**
 * The FFmpeg subsystem (a complex video/audio conversion library).
 */
class FFMpeg
{
    public static function create(): FFMpeg { /* ... */ }

    public function open(string $video): void { /* ... */ }

    // ...そのほか大量のメソッドやクラスなど
}

class FFMpegVideo
{
    public function filters(): self { /* ... */ }

    public function resize(): self { /* ... */ }

    public function synchronize(): self { /* ... */ }

    public function frame(): self { /* ... */ }

    public function save(string $path): self { /* ... */ }

    // ...そのほか大量のメソッドやクラスなど
}


/**
 * クライアントコードはサブシステムのクラスに依存しません。
 * サブシステムのコード内での変更はクライアントコードに影響しません。
 * 必要なのはFacadeを更新することだけです。
 */
function clientCode(YouTubeDownloader $facade)
{
    // ...
    $facade->downloadVideo("https://www.youtube.com/watch?v=jNQXAC9IVRw");
    // ...
}

echo "<pre>";
$facade = new YouTubeDownloader("APIKEY-XXXXXXXXX");
clientCode($facade);
echo "</pre>";
