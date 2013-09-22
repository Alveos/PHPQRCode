<?php
/*
 * PHP QR Code encoder
 *
 * Image output of code using GD2
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

namespace PHPQRCode;

class QRimage {


    //----------------------------------------------------------------------
    public static function png($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$save = TRUE, $print = false) 
    {
        $image = self::image($frame, $pixelPerPoint, $outerFrame, "png", 85, $filename, $save, $print);
    }

    //----------------------------------------------------------------------
    public static function jpg($frame, $filename = false, $pixelPerPoint = 8, $outerFrame = 4, $q = 85,$save = TRUE, $print = false) 
    {
        $image = self::image($frame, $pixelPerPoint, $outerFrame, "jpeg", $q, $filename, $save, $print);
    }

    //----------------------------------------------------------------------
    private static function image($frame, $pixelPerPoint = 4, $outerFrame = 4, $format = "png", $quality = 85, $filename = FALSE, $save = TRUE, $print = false) 
    {
        $imgH = count($frame);
        $imgW = strlen($frame[0]);

        $col[0] = new \ImagickPixel("white");
        $col[1] = new \ImagickPixel("black");

        $image = new \Imagick();
        $image->newImage($imgW, $imgH, $col[0]);

        $image->setCompressionQuality($quality);
        $image->setImageFormat($format); 

        $draw = new \ImagickDraw();
        $draw->setFillColor($col[1]);

        for($y=0; $y<$imgH; $y++) {
            for($x=0; $x<$imgW; $x++) {
                if ($frame[$y][$x] == '1') {
                    $draw->point($x,$y); 
                }
            }
        }

        $image->drawImage($draw);
        $image->borderImage($col[0],$outerFrame,$outerFrame);
        $image->scaleImage( ($imgW + 2*$outerFrame) * $pixelPerPoint, 0 );

        if($save){
            if($filename === false){
                throw new Exception("QR Code filename can't be empty");
            }
            $image->writeImages($filename, true); 
        }

        if($print){
                Header("Content-type: image/" . $format);
                echo $image;
        }
    }    
}