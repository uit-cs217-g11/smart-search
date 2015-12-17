<?php

function InitMobileDetect(&$that)
{
	$that->load->library('Mobile_Detect');
	$detect = new Mobile_Detect;
	
	$that->data['PROFILE_DEVICE'] = DEVICE_UNKNOWN;
	$that->data['PATH_VIEW'] = 'pc';

	if ($detect->isMobile() && !$detect->isTablet())
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_PHONE;
		$that->data['PATH_VIEW'] = 'phone';
	}
	else if ($detect->isTablet())
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_TABLET;
		$that->data['PATH_VIEW'] = 'pc';
	}
	else
	{
		$that->data['PROFILE_DEVICE'] = DEVICE_PC;
		$that->data['PATH_VIEW'] = 'pc';
	}
}

function InitPageNavigation(&$that)
{
	$that->data['SEGMENT_1']	= $that->uri->segment(1);
	$that->data['SEGMENT_2']	= $that->uri->segment(2);
	$that->data['PARAM_1']		= '';
	$that->data['PARAM_2']		= '';
	$that->data['PAGE_NAVIGATION']	= '<a href="/"><i class="fa fa-home fa-lg fa-fw"></i></a>';
	$that->data['META_TITLE']		= 'SMART-SEARCH';
	$that->data['META_SITENAME']	= 'SMART-SEARCH';
}

?>