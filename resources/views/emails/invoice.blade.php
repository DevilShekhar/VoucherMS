<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8" />
   </head>
   <body style="margin: 0; padding: 0; background: #f5f5f5; font-family: Arial, sans-serif;">
      <table width="100%" cellpadding="0" cellspacing="0" style="background: #f5f5f5; padding: 30px 0">
         <tr>
            <td align="center">
               <table width="650" cellpadding="0" cellspacing="0" style=" background: #ffffff;  border-radius: 8px; overflow: hidden;" >
                  <tr>
                     <td  style="background: #0d47a1; color: #fff; padding: 25px; text-align: center;">
                        <h1 style="margin: 0">VMS</h1>
                        <p style="margin: 8px 0 0">Payment Invoice</p>
                     </td>
                  </tr>

                  <tr>
                     <td style="padding: 35px">
                        <h2>Hello {{ $payment->candidate->first_name }},</h2>
                        <p>Thank you for your payment.</p>
                        <p>Your invoice has been generated successfully.</p>
                        <table  width="100%" cellpadding="8" cellspacing="0" style="  border-collapse: collapse; border: 1px solid #ddd;">
                           <tr>
                              <td><strong>Invoice No</strong></td>
                              <td>{{ $payment->invoice->invoice_no }}</td>
                           </tr>
                           <tr>
                              <td><strong>Payment No</strong></td>
                              <td>{{ $payment->payment_no }}</td>
                           </tr>
                           <tr>
                              <td><strong>Candidate</strong></td>
                              <td>
                                 {{ $payment->candidate->first_name }} {{
                                 $payment->candidate->last_name }}
                              </td>
                           </tr>
                           <tr>
                              <td><strong>Course</strong></td>
                              <td>
                                 {{ $payment->candidate->course->course_name ??
                                 '-' }}
                              </td>
                           </tr>
                           <tr>
                              <td><strong>Total Amount</strong></td>
                              <td>
                                 ₹ {{ number_format($payment->net_amount,2) }}
                              </td>
                           </tr>
                        </table>
                        <br />
                        <p>
                           <b
                              >The complete Invoice PDF is attached with this
                              email.</b
                           >
                        </p>
                        <br />
                        Regards,<br />
                        <b>VMS</b>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>
