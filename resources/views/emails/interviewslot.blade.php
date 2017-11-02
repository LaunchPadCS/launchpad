Hey {{$applicant->firstname}}!
<br/>
Thanks for selecting your {{ env('APP_NAME') }} interview time. For your records, you've selected the following slot:
<p>
<b>Day:</b> {{$interview->formattedDay}}<br/>
<b>Time:</b> {{$interview->formattedStartTime}} - {{$interview->formattedEndTime}}<br/>
<b>Location:</b> {{$interview->location}}
</p>
<p>
If you need to change your time slot, please let us know by responding to this email.</p>
<br/>
{{ env('APP_NAME') }} Team