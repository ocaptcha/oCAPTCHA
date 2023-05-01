<?php
// This class creates the oCAPTCHA-image.

class CreateImage {
    private $solution;
    private $background;
    private $overlay;
    private $imageWidth;

    private $assetsPath = '../assets/';
    private $imageSizeBuffer = 10;
    private $imageHeight = 120;
    private $fontSize = [70, 90];
    private $fontRotation = [-30, 30];
    private $fontYOffset = [90, 110];
    private $fontXPosition = 10;
    private $fontSpacing = [60, 75];

    function __construct(string $solution) {
        $this->solution = $solution;
        $this->imageWidth = strlen($solution) * $this->fontSpacing[1] + $this->imageSizeBuffer;
        $this->background = $this->pickBackground();
        $this->overlay = $this->pickOverlay();
    }

    private function pickFont(): string {
        $fonts = scandir($this->assetsPath.'fonts');
        return $this->assetsPath.'fonts/'.$fonts[random_int(2, sizeof($fonts) - 1)];
    }

    private function pickBackground(): GdImage {
        $backgrounds = scandir($this->assetsPath.'backgrounds');
        $backgroundPath = $this->assetsPath.'backgrounds/'.$backgrounds[random_int(2, sizeof($backgrounds) - 1)];
        return imagecreatefromjpeg($backgroundPath);
    }

    private function pickOverlay(): GdImage {
        $overlays = scandir($this->assetsPath.'overlays');
        $overlayPath = $this->assetsPath.'overlays/'.$overlays[random_int(2, sizeof($overlays) - 1)];
        return imagecreatefrompng($overlayPath);
    }

    private function pickFontColor(GdImage $captcha): int {
        $fontColor = imagecolorallocate($captcha, random_int(0, 255), random_int(0, 255), random_int(0, 255));
        return $fontColor;
    }

    private function drawCharacter(GdImage $captcha, int $xPosition, string $character): GdImage {
        $font = $this->pickFont();
        $color = $this->pickFontColor($captcha);
        $rotation = random_int($this->fontRotation[0], $this->fontRotation[1]);
        $yPosition = random_int($this->fontYOffset[0], $this->fontYOffset[1]);
        $size = random_int($this->fontSize[0], $this->fontSize[1]);

        imagettftext($captcha, $size, $rotation, $xPosition, $yPosition, $color, $font, $character);
        $this->fontXPosition += random_int($this->fontSpacing[0], $this->fontSpacing[1]);
        return $captcha;
    }

    function create(): GdImage {
        $captcha = imagecreatetruecolor($this->imageWidth, $this->imageHeight + $this->imageSizeBuffer);
        imagecopy($captcha, $this->background, 0, 0, 0, 0, imagesx($this->background), imagesy($this->background));

        
        for ($i = 0; $i < strlen($this->solution); $i++) {
            $captcha = $this->drawCharacter($captcha, $this->fontXPosition, $this->solution[$i]);
        }

        imagecopy($captcha, $this->overlay, 0, 0, 0, 0, imagesx($this->overlay), imagesy($this->overlay));

        return $captcha;
    }
}
?>