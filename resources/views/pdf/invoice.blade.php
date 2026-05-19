@use('App\Enums\Settings\MediaEnum')
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <title>Invoice</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --background-highlight: #10384e2b;
        }

        .highlight {
            background-color: var(--background-highlight);
        }

        thead {
            background-color: #10384e;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: var(--background-highlight);
        }

        body {
            font-family: "Poppins", sans-serif;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
        }

        /* Invoice wrapper — no fixed height, grows with content */
        .invoice-wrapper {
            width: 100%;
            max-width: 794px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Header ── */
        .invoice-header {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 8px;
            min-height: 150px;
        }

        .logo-wrapper {
            display: grid;
            place-content: center;
        }

        .logo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-wrapper .broken {
            border: 2px solid rgba(0, 0, 255, 0.276);
            aspect-ratio: 6/5;
            width: 200px;
            font-weight: bold;
            font-size: clamp(0.8rem, 1rem + 0.5vw, 2rem);
            display: grid;
            place-content: center;
            text-align: center;
        }

        .header-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .header-info-inner {
            width: 50%;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            gap: 6px;
        }

        .invoice-title {
            font-weight: 700;
            font-size: 3rem;
            text-align: right;
        }

        .invoice-meta-row {
            display: flex;
            justify-content: space-between;
        }

        .invoice-meta-row .label {
            font-weight: 700;
        }

        /* ── Invoice Info ── */
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            min-height: 140px;
        }

        .from-block,
        .bill-block {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            gap: 4px;
            font-size: 1rem;
        }

        .bill-block {
            text-align: right;
        }

        .from-block .company-name,
        .bill-block .client-name {
            font-size: 1.875rem;
            font-weight: 700;
        }

        .text-gray {
            color: rgb(128, 127, 127);
            font-weight: 500;
        }

        /* ── Ship To ── */
        .ship-to {
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            gap: 4px;
            min-height: 80px;
        }

        .ship-to .ship-name {
            font-weight: 600;
        }

        /* ── Invoice Table ── */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table thead tr th {
            text-align: left;
            padding: 10px 6px;
            border-bottom: 2px solid #e5e7eb;
        }

        .invoice-table thead tr th:not(:first-child) {
            text-align: center;
        }

        .invoice-table tbody tr td {
            padding: 10px 6px;
            border-bottom: 1px solid #f3f4f6;
            text-align: center;
        }

        .invoice-table tbody tr td:first-child {
            text-align: left;
        }

        /* ── Payment Info ── */
        .payment-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .payment-instructions {
            display: flex;
            gap: 8px;
            flex-direction: column;
        }

        .payment-instructions .payment-title {
            font-weight: 700;
            font-size: 1.125rem;
        }

        .payment-instructions p {
            font-size: 1rem;
        }

        .totals-block {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
        }

        .totals-row .label {
            font-weight: 700;
        }

        /* ── Notes ── */
        .notes {
            margin-top: 1.5rem;
            margin-bottom: 3rem;
        }

        .notes h2 {
            font-size: 1.2rem;
        }

        .notes p {
            padding-top: 1.2rem;
            font-size: 1rem;
            text-align: justify;
            text-indent: 5rem;
        }

        /* ── Signatures ── */
        .signatures {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            text-align: center;
            gap: 8px;
            margin-top: 24px;
            padding-bottom: 20px;
        }

        .signature-block {
            width: 280px;
        }

        .signature-label {
            font-weight: 700;
            font-size: 1rem;
            border-top: 1px solid currentColor;
            padding-top: 4px;
        }

        /* ── Watermark ── */
        .watermark {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            width: 75%;
        }

        .watermark img {
            width: 100%;
        }

        /* Position variants */
        .watermark.center {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .watermark.top-left {
            top: 20px;
            left: 20px;
            width: 35%;
            /* transform: rotate(-45deg); */
        }

        .watermark.top-right {
            top: 20px;
            right: 20px;
            left: auto;
            width: 35%;
            /* transform: rotate(45deg); */
        }

        .watermark.bottom-left {
            bottom: 20px;
            top: auto;
            left: 20px;
            width: 35%;
            /* transform: rotate(45deg); */
        }

        .watermark.bottom-right {
            bottom: 20px;
            top: auto;
            right: 20px;
            left: auto;
            width: 35%;
            /* transform: rotate(-45deg); */
        }
    </style>
    <link rel="stylesheet" href="assets/css/app.css" />
</head>

<body>
    <!-- Invoice wrapper -->
    <div class="invoice-wrapper">
        <!-- Header -->
        <div class="invoice-header">
            <div class="logo-wrapper">
                <img src="{{ Storage::disk('public')->path($company_logo) }}" alt="{{ $company_brand }} Logo"
                    onerror="this.classList.add('broken')" />
            </div>
            <div class="header-info">
                <div class="header-info-inner">
                    <h1 class="invoice-title">Invoice</h1>
                    <div class="invoice-meta-row">
                        <p class="label">Invoice no#</p>
                        <p>{{ $invoice['invoice_number'] }}</p>
                    </div>
                    <div class="invoice-meta-row">
                        <p class="label">Invoice Date:</p>
                        <p>{{ $invoice['invoice_date'] }}</p>
                    </div>
                    <div class="invoice-meta-row">
                        <p class="label">Due Date:</p>
                        <p>{{ $invoice['invoice_due'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Header -->

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="from-block">
                <p class="company-name">{{ $company_brand }}</p>
                <p>{{ $invoice['company_email'] }}</p>
                <p>Contact Number: {{ $invoice['company_phone'] }}</p>
                <p>{{ $invoice['company_website'] }}</p>
                <p>{{ $invoice['company_address'] }}</p>
            </div>

            <div class="bill-block">
                <p class="client-name">{{ $invoice['client_name'] }}</p>
                <p>{{ $invoice['client_email'] }}</p>
                <p>Contact Number: {{ $invoice['client_phone'] }}</p>
                <p>{{ $invoice['client_website'] }}</p>
                <p>{{ $invoice['client_address'] }}</p>
            </div>
        </div>

        <div class="ship-to">
            <p>Ship to:</p>
            <p class="ship-name">{{ $invoice['shipment_address'] }}</p>
            <p>Tracking Number: {{ $invoice['shipment_tracking_number'] }}</p>
        </div>
        <!-- /Invoice Info -->

        <!-- Invoice Table -->
        <div class="invoice-table-wrapper">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>

                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                    <tr>
                        <td>Web Design</td>
                        <td>1</td>
                        <td>₱5,000</td>
                        <td>₱5,000</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /Invoice Table -->

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-instructions">
                <p class="payment-title">Payment Instructions:</p>
                <p>Dharjay Pogi 69</p>
                <p>Gcash</p>
            </div>

            <div class="totals-block">
                <div class="totals-row highlight">
                    <p class="label">Sub Total:</p>
                    <p>₱69,696,699</p>
                </div>
                <div class="totals-row">
                    <p class="label">Discount:</p>
                    <p>69%</p>
                </div>
                <div class="totals-row">
                    <p class="label">Shipping Cost:</p>
                    <p>₱699</p>
                </div>
                <div class="totals-row highlight">
                    <p class="label">Total Price:</p>
                    <p>₱69,696,699</p>
                </div>
                <div class="totals-row">
                    <p class="label">Amount Paid:</p>
                    <p>₱69,696,699</p>
                </div>
                <div class="totals-row highlight">
                    <p class="label">Due Date:</p>
                    <p>₱{{ $invoice['due_penalty'] }}</p>
                </div>
            </div>
        </div>
        <!-- /Payment Info -->

        @if (!empty($invoice['note']))
            <!-- /Payment Info -->
            <div class="notes">
                <h2>Notes:</h2>
                <p>
                    {{ $invoice['note'] }}
                </p>
            </div>
            <!-- /Payment Info -->
        @endif

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-block">
                <div class="signature-label">
                    Signature Over Printed Name
                </div>
            </div>
            <div class="signature-block">
                <div class="signature-label">NexaNode Org.</div>
            </div>
        </div>
        <!-- /Signatures -->

        @if (setting(MediaEnum::WatermarkEnabled->value, false))
            <div class="watermark {{ setting(MediaEnum::WatermarkPosition->value, 'center') }}"
                style="opacity: {{ setting(MediaEnum::WatermarkOpacity->value, 20) }}%;">
                <img src="{{ Storage::disk('public')->path(setting(MediaEnum::WatermarkImage->value)) }}"
                    alt="{{ $company_brand }}" />
            </div>
        @endif
    </div>
    <!-- /Invoice wrapper -->
</body>

</html>
