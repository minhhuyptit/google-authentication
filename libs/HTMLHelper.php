<?php
    class HTMLHelper{
		public static function showMessage($content, $type = "error") {
            $xhtml = '';
            if(!empty($content)) {
                $class = 'danger';
                if($type == "success") {
                    $class = 'success';
                }
                return '<div class="alert alert-'.$class.'">' . $content . '</div>';
            }
            return null;
        }
    }
?>