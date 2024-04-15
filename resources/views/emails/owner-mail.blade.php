<div style="color:#000">
    <p><b>Subject:</b> Service Package Expiry Notification for Client {{ $details->director_name}}</p>

    <p style="color:#000">Dear Gaurav,</p>


    <p style="color:#000">Service package for client {{ $details->company_name}} will expire on {{ \Carbon\Carbon::parse($details->due_date)->format('d-m-Y')}} and is pending renewal.
    Kindly contact and guide them on the next steps to renew their package and ensure uninterrupted service.
    Thank you for your attention to this matter.
    </p>
    <p style="color:#000">Best regards,</p>
    <p style="color:#000">Vselek Bot</p>
</div>
