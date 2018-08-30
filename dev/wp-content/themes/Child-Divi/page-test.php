<?php /* Template Name: BBB Admin Account Registration */ 








//$a = shell_exec("mkdir this_folder 2>&1");
//echo $a;
$b = shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/2018/08/StudentVideoContest2018_Generic8.mp4 -vcodec h264 -acodec mp3 /var/www/www.bbbvideocontest.org/dev/wp-content/themes/Child-Divi/output6.mp4 2>&1 & ");
     echo $b;

function isEnabled($func) {
    return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}
if (isEnabled('shell_exec')) {
/*     shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/2018/08/StudentVideoContest2018_Generic8.mp4 -vcodec h264 -acodec mp3 /home/leonarda/output5.mp4 ");
     echo "Done";*/
}else{
    echo "No";
}

/*    $test = shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/2018/08/StudentVideoContest2018_Generic8.mp4 -vcodec h264 -acodec mp3 /home/leonarda/output4.mp4");*/
?>
