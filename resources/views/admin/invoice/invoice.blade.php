<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />

      <style>
         body {
            font-family: DejaVu Sans;
            font-size: 12px;
            color: #333;
            margin: 20px;
         }

         table {
            width: 100%;
            border-collapse: collapse;
         }

         .header {
            background: #0d47a1;
            color: #fff;
         }

         .header td {
            border: none;
            padding: 12px;
            vertical-align: top;
         }

         .company-name {
            font-size: 22px;
            font-weight: bold;
         }

         .company-sub {
            font-size: 11px;
            margin-top: 4px;
         }

         .invoice-title {
            font-size: 30px;
            font-weight: bold;
            text-align: right;
         }

         .invoice-info {
            text-align: right;
            margin-top: 8px;
            font-size: 12px;
         }

         .section {
            margin-top: 20px;
         }

         .info-table td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: top;
         }

         .section-title {
            background: #f1f5f9;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #ccc;
         }

         .status-paid {
            color: green;
            font-weight: bold;
            font-size: 14px;
         }

         .payment-table th {
            background: #0d47a1;
            color: white;
            padding: 8px;
            border: 1px solid #ccc;
         }

         .payment-table td {
            border: 1px solid #ccc;
            padding: 8px;
         }

         .payment-table .total {
            background: #e8f5e9;
            font-weight: bold;
         }

         .payment-table .balance {
            background: #fff3cd;
            font-weight: bold;
         }

         .right {
            text-align: right;
         }

         .terms {
            margin-top: 35px;
            font-size: 11px;
         }

         .signature {
            width: 220px;
            float: right;
            text-align: center;
            margin-top: 60px;
         }

         .signature hr {
            border: none;
            border-top: 1px solid #000;
         }
      </style>
   </head>

   <body>
      <table class="header">
         <tr>
            <td width="65%">
               <div class="company-name">CARE CONNECT TRUST</div>

               <div class="company-sub">Excellence in Healthcare Education</div>

               <div style="margin-top: 10px">
                  Phone : +91-9876543210<br />

                  Email : info@careconnecttrust.com<br />

                  Website : www.careconnecttrust.com
               </div>
            </td>

            <td width="35%">
               <div class="invoice-title">INVOICE</div>

               <div class="invoice-info">
                  <b>Invoice No :</b>

                  {{ $invoice->invoice_no }}

                  <br /><br />

                  <b>Date :</b>

                  {{
                  \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y')
                  }}
               </div>
            </td>
         </tr>
      </table>

      <div class="section">
         <table class="info-table">
            <tr>
               <td width="70%">
                  <div class="section-title">BILL TO</div>

                  <br />

                  <b>Candidate :</b>

                  {{ $invoice->candidate->first_name }} {{
                  $invoice->candidate->last_name }}

                  <br /><br />

                  <b>Candidate Code :</b>

                  {{ $invoice->candidate->candidate_code }}

                  <br /><br />

                  <b>Course :</b>

                  {{ $invoice->candidate->course->course_name ?? '-' }}

                  <br /><br />

                  <b>Center :</b>

                  {{ $invoice->candidate->center->center_name ?? '-' }}
               </td>

               <td width="30%">
                  <div class="section-title">PAYMENT STATUS</div>

                  <br />

                  <div class="status-paid">
                     @if($invoice->payment->pending_amount==0) ● PAID
                     @elseif($invoice->payment->paid_amount==0) ● UNPAID @else ●
                     PARTIAL @endif
                  </div>
               </td>
            </tr>
         </table>
      </div>

      <div class="section">
         <table class="payment-table">
            <tr>
               <th>Description</th>

               <th width="30%">Amount</th>
            </tr>

            <tr>
               <td>Total Amount</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->total_amount,2) }}
               </td>
            </tr>

            <tr>
               <td>Discount</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->discount_amount,2) }}
               </td>
            </tr>

            <tr>
               <td>GST / Tax</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->tax_amount,2) }}
               </td>
            </tr>

            <tr class="total">
               <td>NET AMOUNT</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->net_amount,2) }}
               </td>
            </tr>

            <tr>
               <td>PAID AMOUNT</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->paid_amount,2) }}
               </td>
            </tr>

            <tr class="balance">
               <td>BALANCE</td>

               <td class="right">
                  ₹ {{ number_format($invoice->payment->pending_amount,2) }}
               </td>
            </tr>
         </table>
      </div>

      <div class="terms">
         <b>Terms & Conditions</b>

         <ul>
            <li>Fees once paid are non-refundable.</li>

            <li>Please keep this invoice for future reference.</li>

            <li>This invoice is computer generated.</li>
         </ul>
      </div>

      <div class="signature">
         <hr />

         Authorized Signature
      </div>
   </body>
</html>
