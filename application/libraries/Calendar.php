<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function allotmentData($hotel_id,$room_id,$date,$con_id) {
      $ci =& get_instance();
      $query1 = $ci->db->query('select a.allotement,a.allotement_date,a.hotel_id,a.room_id,a.contract_id,a.contract_fr_id,con.contract_type,a.amount,
IF(con.contract_type="Main",(select GetAllotment(a.allotement_date,a.hotel_id,con.id,a.room_id)),(select GetAllotment(a.allotement_date,a.hotel_id,con.linkedContract,a.room_id))) as alt,
IF(con.contract_type="Main",(select GetBookedcount(a.allotement_date,a.hotel_id,con.id,a.room_id)) ,(select GetBookedcount(a.allotement_date,a.hotel_id,con.linkedContract,a.room_id))) as booked,
IF(con.contract_type="Main",a.cut_off,(select GetcutOff(a.allotement_date,a.hotel_id,con.linkedContract,a.room_id))) as cutOFF,
IF(cls.closedDate!="","close","open") as closed,
count(cp.cancellationPercentage) as cancellation 
from hotel_tbl_allotement a 
inner join hotel_tbl_contract con on con.id = a.contract_fr_id 
left join hotel_tbl_closeout_period cls ON cls.contract_id = a.contract_id and FIND_IN_SET(a.room_id,cls.roomType) > 0 and cls.closedDate = a.allotement_date 
left join hotel_tbl_cancellationfee cp ON cp.contract_id = a.contract_id and FIND_IN_SET(a.room_id,cp.roomType) > 0 and a.allotement_date BETWEEN fromDate and toDate
where a.contract_fr_id = '.str_replace("CON0", "", $con_id).' and a.allotement_date = "'.$date.'" and a.room_id = '.$room_id.' group by a.allotement_date')->result();
      return $query1;
    }
   
    public function Editpermission($date) {
      $button = "";
      if ($date >= date('Y-m-d')) {
        $button = '<i class="fa fa-edit editCal" data-toggle="modal" data-target="#calModal"></i>';
      }
      return $button;
    }
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar"><form method="post" id="allotement_update_form">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</form></div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;
            $allotmentData = $this->allotmentData($_GET['hotel_id'],$_GET['room_id'],$this->currentDate,$_GET['con_id']); 
            if (count($allotmentData)!=0) {
              $room_amount = round(contract_currency_type(hotel_currency_type($_GET['hotel_id']),$allotmentData[0]->amount));
              $room_allotement = $allotmentData[0]->alt;
              $real_allotement = $allotmentData[0]->allotement;
              $room_cut_off = $allotmentData[0]->cutOFF;
              $room_booking = $allotmentData[0]->booked;
              $room_balance = ($allotmentData[0]->alt)-($allotmentData[0]->booked);
            
              if ($allotmentData[0]->closed=='close') {
                $closedOut = '<img src="'.base_url().'assets/images/closed.jpg" style="width: 70%;opaacity: 0.7;padding-top:15px;">';
              } else {
                $closedOut = '';
              }
              if ($allotmentData[0]->cancellation!=0) {
               $cp = '<span onclick="cancellationPolicytitle(\''.$this->currentDate.'\',\''.$_GET['con_id'].'\',\''.$_GET['room_id'].'\')" class="cp-style" data-toggle="modal" data-target="#canModal">CP</span>';
              } else {
                $cp = '';
              }
            }   else {

              $room_amount = 0;
              $room_allotement = 0;
              $real_allotement = 0;
              $room_cut_off = 0;
              $room_booking = 0;
              $room_balance = 0;
              $closedOut = '';
              $cp = '';
            }
        }else{
             
            $this->currentDate =null;
            $cellContent=null;

            $room_amount = 0;
            $room_allotement = 0;
            $real_allotement = 0;
            $room_cut_off = 0;
            $room_booking = 0;
            $room_balance = 0;
            $closedOut = '';
            $cp = '';
        }
        

        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'"><input type="hidden" class="alt-price-li-'.$this->currentDate.'" name="price[]" value="'.$room_amount.'"/>
                '.$closedOut.'
                <input type="hidden"  name="alotement_date[]" value="'.$this->currentDate.'"/>
                <input type="hidden" class="alt-roomalt-li-'.$this->currentDate.'" name="alotement[]" value="'.$real_allotement.'"/>
                <input type="hidden" class="alt-cut-off-li-'.$this->currentDate.'" name="cut_off[]" value="'.$room_cut_off.'"/>
                <input type="hidden" name="hotel_id[]" value="'.$_GET['hotel_id'].'"/>
                <input type="hidden" name="contract_id[]" value="'.$_GET['con_id'].'"/>
                <input type="hidden" name="room_id[]" value="'.$_GET['room_id'].'"/>
                
                <span class="cal-date">'.$this->Editpermission($this->currentDate).$cp.$cellContent.'</span>
                <div class="cal-info-group">
                    <div class="cal-amt">Amount :<span class="input">'.$room_amount.'</span></div>
                    <div class="cal-alot-real hide">Allocation : <span class="input">'.$real_allotement.'</span></div>
                    <div class="cal-alot">Allocation : <span class="input">'.$room_allotement.'</span></div>
                    <div class="cal-bal">Cut-off :<span class="input">'.$room_cut_off.'</span></div>
                <div class="cal-bkd">Booked : <span class="input">'.$room_booking.'</span></div>
                <div class="cal-bal-room">Balance : <span class="input">'.$room_balance.'</span></div>
                </div><span class="hidden"><i class="fa fa-buysellads"></i></span><span class="hidden"></span></li>';
    }
    /**
    * create navigation
    */
    private function _createNavi(){     
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.base_url().'backend/hotels/contractProcess?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'&hotel_id='.$_GET['hotel_id'].'&room_id='.$_GET['room_id'].'&con_id='.$_GET['con_id'].'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.base_url().'backend/hotels/contractProcess?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'&hotel_id='.$_GET['hotel_id'].'&room_id='.$_GET['room_id'].'&con_id='.$_GET['con_id'].'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}
