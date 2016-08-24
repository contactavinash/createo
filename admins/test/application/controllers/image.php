<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image extends CI_Controller {
    private function createimage() {
    }
    public function index() {
        $this->load->helper('file');
        $name = $this->input->get("name");
        $extension = explode(".", $name);
        $extension = $extension[count($extension) - 1];
        //echo $extension;
        $width = intval($this->input->get("width"));
        $height = intval($this->input->get("height"));
        $imagepath = "./uploads/" . $name;
        $newfilename = $name;
        if ($width != 0 && $height != 0) {
            $newfilename = "thumb/thumb_w_" . $width . "_h_" . $height . "_" . $name;
        } else if ($width != 0 && $height == 0) {
            $newfilename = "thumb/thumb_w_" . $width . "_" . $name;
        } else if ($width == 0 && $height != 0) {
            $newfilename = "thumb/thumb_h_" . $height . "_$name";
        } else if ($width == 0 && $height == 0) {
        }
        $thumbstring = read_file("./uploads/".$newfilename);
        if ($thumbstring) {
            if ($extension == "jpg" || $extension == "jpeg") {
                header("content-type:image/jpeg");
                echo $thumbstring;
                return 0;
            } else if ($extension == "png") {
                header("content-type:image/png");
                echo $thumbstring;
                return 0;
            } else {
                header("content-type:image/jpeg");
                echo $thumbstring;
                return 0;
            }
        } else {
            $string = read_file($imagepath);
            //echo $originalwidth;
            if ($string) {
                if ($extension == "jpg" || $extension == "jpeg") {
                    // header("content-type:image/jpeg");
                    $photo = @imagecreatefromjpeg("$imagepath");
                } else if ($extension == "png") {
                    // header("content-type:image/png");
                    $photo = @imagecreatefrompng("$imagepath");
                } else {
                    header("content-type:image/jpeg");
					echo read_file("./uploads/no-format.jpg");
					return 0;
                }
            } else {
                // header("content-type:image/jpeg");
                $photo = @imagecreatefromjpeg("./uploads/noimage.jpg");
            }
            $originalwidth = imagesx($photo);
            $originalheight = imagesy($photo);
            $ratio = $originalwidth / $originalheight;
            // echo $ratio;
            $newwidth = 0;
            $newheight = 0;
            if ($width != 0 && $height != 0) {
                $newwidth = $width;
                $newheight = $height;
            } else if ($width != 0 && $height == 0) {
                $newwidth = $width;
                $newheight = $width / $ratio;
            } else if ($width == 0 && $height != 0) {
                $newwidth = $ratio * $height;
                $newheight = $height;
            } else if ($width == 0 && $height == 0) {
                $newwidth = $originalwidth;
                $newheight = $originalheight;
            }

            $newimage = @imagecreatetruecolor($newwidth, $newheight);
            imagealphablending($newimage, false);
            imagesavealpha($newimage, true);
            imagecopyresized($newimage, $photo, 0, 0, 0, 0, $newwidth, $newheight, $originalwidth, $originalheight);
            if ($extension == "jpg" || $extension == "jpeg") {
                imagejpeg($newimage, "./uploads/$newfilename", 100);
                header("content-type:image/jpeg");
                $thumbstring = read_file("./uploads/".$newfilename);
                echo $thumbstring;

            } else {
                imagepng($newimage, "./uploads/$newfilename");
                header("content-type:image/png");
                $thumbstring = read_file("./uploads/".$newfilename);
                echo $thumbstring;
            }
        }
    }
}
?>
