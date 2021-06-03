<p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
  <span class="font-weight500" >{{ date('M jS Y',strtotime($created_at)) }},</span></p>
<p ><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500" >{{ date('h:i A',strtotime($created_at)) }}</span></p>

<p class="border-grey"></p>

<p>
   <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
   <span class="font-weight500">{{ date('M jS Y',strtotime($updated_at)) }}</span>
</p>

<p><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500">{{ date('h:i A',strtotime($updated_at)) }}</span></p>