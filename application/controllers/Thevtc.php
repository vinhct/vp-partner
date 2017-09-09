<?php
Class thevtc extends MY_Controller
{
    function index()
    {
    	date_default_timezone_set('Asia/Ho_Chi_Minh');
    	 $now = new \DateTime('now');
       $month = $now->format('m')-1;
       $year = $now->format('Y');
        $start_time = null;
        $end_time = null;
         if ($this->input->post('toDate')) {
            $end_time = $this->input->post('toDate');
        }

        if ($this->input->post('fromDate')) {
            $start_time = $this->input->post('fromDate');
        }

        if ($start_time === null) {
            $start_time = date('Y-m-d 00:00:00');
        }
        if ($end_time === null) {
            $end_time = date('Y-m-d H:i:s');
        }
        $this->data['start_time'] = $start_time;
        $this->data['end_time'] = $end_time;
        $this->data['temp'] = 'admin/thevtc/index';
        $this->load->view('admin/main', $this->data);
    }
    function lastday($month = '', $year = '') {
	   if (empty($month)) {
		  $month = date('m');
	   }
	   if (empty($year)) {
		  $year = date('Y');
	   }
	   $result = strtotime("{$year}-{$month}-01");
	   $result = strtotime('-1 second', strtotime('+1 month', $result));
	   return date('Y-m-d 23:59:59', $result);
	}

	function firstDay($month = '', $year = '')
	{
		if (empty($month)) {
		  $month = date('m');
	   }
	   if (empty($year)) {
		  $year = date('Y');
	   }
	   $result = strtotime("{$year}-{$month}-01");
	   return date('Y-m-d 00:00:00', $result);
	} 
	
}
?>