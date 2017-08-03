<?php

//数字转为星期
if (! function_exists('numtoweek')) {
    function numtoweek($num) {
    	switch ($num)
    	{
    		case 0:
    			return "星期日";
    			break;
    		case 1:
    			return "星期一";
    			break;
    		case 2:
    			return "星期二";
    			break;
    		case 3:
    			return "星期三";
    			break;
    		case 4:
    			return "星期四";
    			break;
    		case 5:
    			return "星期五";
    			break;
    		case 6:
    			return "星期六";
    			break;
    		default:
    			return "未知";
    	}
    }
}

//星期转为数字
if (! function_exists('weektonum')) {
    function weektonum($week) {
    	switch ($week)
    	{
    		case "星期日":
    			return 0;
    			break;
    		case "星期一":
    			return 1;
    			break;
    		case "星期二":
    			return 2;
    			break;
    		case "星期三":
    			return 3;
    			break;
    		case "星期四":
    			return 4;
    			break;
    		case "星期五":
    			return 5;
    			break;
    		case "星期六":
    			return 6;
    			break;
    		default:
    			return 0;
    	}
    }
}

?>