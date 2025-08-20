@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoices - SSA Technology</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: white;
            padding: 8mm;
        }

        @page {
            size: A4;
            margin: 8mm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 0;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .no-print {
                display: none !important;
            }
            
            .invoice {
                page-break-inside: avoid;
                break-inside: avoid;
                orphans: 1;
                widows: 1;
            }
            
            /* Optimize space usage on A4 */
            .print-container {
                max-width: 210mm;
                height: auto;
            }
        }

        .print-container {
            width: 100%;
            max-width: 194mm;
            margin: 0 auto;
        }

        .invoice {
            border: 2px solid #333;
            width: 100%;
            min-height: 75mm;
            height: auto;
            margin-bottom: 4mm;
            page-break-inside: avoid;
            background: white;
            display: grid;
            grid-template-rows: auto 1fr;
            break-inside: avoid;
        }

        /* Let CSS automatically handle page breaks based on available space */

        .invoice-header {
            background: #fff;
            border-bottom: 2px solid #000;
            padding: 2mm 4mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            grid-row: 1;
        }

        .header-left {
            text-align: left;
            flex: 1;
        }

        .header-right {
            text-align: right;
            flex: 1;
        }

        .invoice-title {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .invoice-subtitle {
            font-size: 9px;
            color: #000;
            margin: 0;
        }

        .order-info {
            display: none;
        }

        .order-id {
            font-size: 13px;
            font-weight: bold;
            color: #000;
        }

        .order-date {
            font-size: 10px;
            color: #000;
            margin-top: 2px;
        }

        .invoice-body {
            display: flex;
            grid-row: 2;
            height: 100%;
            overflow: hidden;
        }

        .invoice-section {
            flex: 1;
            padding: 3mm;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .to-section {
            border-right: 2px solid #333;
            max-width: calc(50% - 1px);
        }

        .from-section {
            max-width: 50%;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            background: #fff;
            border: 1px solid #000;
            padding: 1.5mm;
            text-align: center;
            margin-bottom: 1.5mm;
            flex-shrink: 0;
        }

        .section-content {
            flex: 1;
            overflow: visible;
        }

        .detail-row {
            display: flex;
            margin-bottom: 1.5mm;
            align-items: flex-start;
            overflow: visible;
        }

        .detail-label {
            font-weight: bold;
            color: #000;
            font-size: 12px;
            min-width: 18mm;
            max-width: 18mm;
            flex-shrink: 0;
            margin-right: 2mm;
            text-align: left;
        }

        .detail-value {
            color: #000;
            font-size: 13px;
            flex: 1;
            word-break: break-word;
            overflow-wrap: break-word;
            line-height: 1.2;
            overflow: visible;
        }

        .phone-number {
            font-weight: bold;
            font-size: 15px;
            color: #000;
        }

        .city-country {
            font-weight: bold;
            font-size: 15px;
            color: #000;
        }

        .company-info {
            font-weight: bold;
            color: #000;
            font-size: 18px;
        }

        .customer-name {
            font-weight: bold;
            font-size: 16px;
            color: #000;
        }

        .address-text {
            font-size: 15px;
            font-weight: 500;
            color: #000;
            line-height: 1.3;
        }

        .semesters-container {
            display: flex;
            margin-bottom: 1.5mm;
            align-items: flex-start;
            overflow: visible;
        }

        .semesters {
            background: #fff;
            border: 1px solid #000;
            padding: 1mm;
            border-radius: 1mm;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5mm;
            flex: 1;
            overflow: hidden;
        }

        .semester-badge {
            background: #fff;
            color: #000;
            border: 1px solid #000;
            padding: 0.5mm 1mm;
            border-radius: 0.5mm;
            font-size: 7px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .remarks-container {
            display: flex;
            margin-bottom: 1.5mm;
            align-items: flex-start;
            overflow: visible;
        }

        .remarks {
            background: #fff;
            border: 1px solid #000;
            padding: 1.5mm;
            border-radius: 1mm;
            font-style: italic;
            font-size: 9px;
            word-break: break-word;
            overflow-wrap: break-word;
            flex: 1;
            line-height: 1.2;
            overflow: visible;
        }

        .company-address {
            display: flex;
            flex-direction: column;
            gap: 1mm;
            overflow: hidden;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            color: #000;
            border: 2px solid #000;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }

        .print-button:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Invoices
    </button>

    <div class="print-container">
        @foreach($orders as $order)
            <div class="invoice">
                <div class="invoice-header">
                    <div class="header-left">
                        <div class="invoice-title">SEMESTER NOTES ORDER</div>
                        <div class="invoice-subtitle">SSA Technology</div>
                    </div>
                    <div class="header-right">
                        <div class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="order-date">{{ $order->created_at->format('M j, Y - g:i A') }}</div>
                    </div>
                </div>

                <div class="invoice-body">
                    <!-- TO Section (Customer Details) -->
                    <div class="invoice-section to-section">
                        <div class="section-title">TO</div>
                        
                        <div class="section-content">
                            <div class="detail-row">
                                <span class="detail-label">Name:</span>
                                <div class="detail-value customer-name">{{ Str::title($order->name) }}</div>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label">Phone:</span>
                                <div class="detail-value phone-number">{{ $order->phone_number }}</div>
                            </div>

                            @if(!empty($order->secondary_phone_number))
                                <div class="detail-row">
                                    <span class="detail-label">Phone 2:</span>
                                    <div class="detail-value phone-number">{{ $order->secondary_phone_number }}</div>
                                </div>
                            @endif

                            <div class="detail-row">
                                <span class="detail-label">Address:</span>
                                <div class="detail-value address-text">
                                    @php
                                        $address = trim($order->full_address);
                                        // Check if address already contains commas
                                        if (strpos($address, ',') === false) {
                                            // No commas found, convert line breaks to commas
                                            // Handle different line break formats
                                            $address = preg_replace('/\r\n|\r|\n/', ', ', $address);
                                            // Clean up multiple spaces and trim
                                            $address = preg_replace('/\s+/', ' ', $address);
                                            // Remove any double commas that might occur
                                            $address = preg_replace('/,\s*,+/', ', ', $address);
                                            // Remove trailing comma and spaces
                                            $address = rtrim($address, ', ');
                                        } else {
                                            // Address has commas, just clean up extra spaces
                                            $address = preg_replace('/\s+/', ' ', $address);
                                        }
                                        // Capitalize each word
                                        $address = Str::title($address);
                                    @endphp
                                    {{ $address }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label">City:</span>
                                <div class="detail-value city-country">{{ Str::title($order->city) }}</div>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label">Country:</span>
                                <div class="detail-value city-country">{{ Str::title($order->country) }}</div>
                            </div>

                            <div class="semesters-container">
                                <span class="detail-label">Notes:</span>
                                <div class="semesters">
                                    @foreach($order->semesters as $semester)
                                        <span class="semester-badge">{{ Str::title($semester) }}</span>
                                    @endforeach
                                </div>
                            </div>

                            @php
                                $remarks = trim(strtolower($order->remarks ?? ''));
                                $emptyValues = ['', 'null', 'nil', 'nothing', 'not', 'no', 'n/a', 'na', '-', '.', 'none'];
                                $showRemarks = !empty($remarks) && !in_array($remarks, $emptyValues);
                            @endphp
                            @if($showRemarks)
                                <div class="remarks-container">
                                    <span class="detail-label">Remarks:</span>
                                    <div class="remarks">{{ Str::title($order->remarks) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- FROM Section (Company Details) -->
                    <div class="invoice-section from-section">
                        <div class="section-title">FROM</div>
                        
                        <div class="section-content">
                            <div class="company-address">
                                <div class="detail-value company-info">SSA Techs</div>
                                
                                <div class="detail-row">
                                    <span class="detail-label">Address:</span>
                                    <div class="detail-value address-text">Tordher Tehsil Lahor</div>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label"></span>
                                    <div class="detail-value address-text">District Swabi, KPK Pakistan</div>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Postal Code:</span>
                                    <div class="detail-value">23610</div>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Phone:</span>
                                    <div class="detail-value phone-number">☎ 03409148304</div>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Service:</span>
                                    <div class="detail-value">Semester Notes Supply</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        // Auto-print when page loads
        window.addEventListener('load', function() {
            // Small delay to ensure everything is loaded
            setTimeout(function() {
                // Remove the print button before printing
                const printBtn = document.querySelector('.print-button');
                if (printBtn) {
                    printBtn.style.display = 'none';
                }
                
                // Auto print
                window.print();
                
                // Close window after printing (optional)
                window.addEventListener('afterprint', function() {
                    window.close();
                });
            }, 500);
        });
    </script>
</body>
</html>