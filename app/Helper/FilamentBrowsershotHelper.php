<?php
namespace App\Helper;

use App\Enums\Settings\MediaEnum;
use App\Enums\Settings\Puppeteer\FileFormatEnum;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class FilamentBrowsershotHelper
{
    private FileFormatEnum $format = FileFormatEnum::A4;
    private float $width           = 0;
    private float $height          = 0;
    private float $margin_tp       = 0;
    private float $margin_bt       = 0;
    private float $margin_rt       = 0;
    private float $margin_lt       = 0;
    private bool $landscape        = false;
    private float $scale           = 1;
    private bool $background       = true;
    private bool $eager            = true;
    private array $table_data;
    private mixed $company_logo;
    private mixed $company_brand;
    private array $invoice_data;

    public function __construct(array $tableData)
    {
        $this->table_data    = $tableData;
        $this->company_logo  = setting(MediaEnum::LightmodeLogo->value);
        $this->company_brand = setting(MediaEnum::Name->value);
    }

    public function format(FileFormatEnum $format = FileFormatEnum::A4): static
    {
        $this->format = $format;
        return $this;
    }

    public function paperSize(float $width, float $height): static
    {
        $this->width  = $width;
        $this->height = $height;
        return $this;
    }

    public function margin(float $top = 0, float $right = 0, float $bottom = 0, float $left = 0): static
    {
        $this->margin_tp = $top;
        $this->margin_rt = $right;
        $this->margin_bt = $bottom;
        $this->margin_lt = $left;
        return $this;
    }

    public function marginFromArray(array $margins): static
    {
        [$this->margin_tp, $this->margin_rt, $this->margin_bt, $this->margin_lt] = $margins;
        return $this;
    }

    public function scale(float $value): static
    {
        $this->scale = max(0.1, min(2, $value));
        return $this;
    }

    public function landscape(bool $value = true): static
    {
        $this->landscape = $value;
        return $this;
    }

    public function background(bool $value = true): static
    {
        $this->background = $value;
        return $this;
    }

    public function eager(bool $value = true): static
    {
        $this->eager = $value;
        return $this;
    }

    public function pdf(string $view, string $filename = 'document.pdf')
    {
        $html = View::make($view, array_merge([
            'table_data' => $this->table_data,
            'company_logo' => $this->company_logo,
            'company_brand' => $this->company_brand,
        ], $this->invoice_data))->render();

        $browsershot = Browsershot::html($html)
            ->scale($this->scale)
            ->showBackground($this->background);

        // custom paper size takes priority over format
        if ($this->width && $this->height) {
            $browsershot->paperSize($this->width, $this->height);
        } else {
            $browsershot->format($this->format->value);
        }

        // only apply margins if any are set
        if ($this->margin_tp || $this->margin_rt || $this->margin_bt || $this->margin_lt) {
            $browsershot->margins($this->margin_tp, $this->margin_rt, $this->margin_bt, $this->margin_lt);
        }

        if ($this->landscape) {
            $browsershot->landscape();
        }

        if ($this->eager) {
            $browsershot->waitUntilNetworkIdle();
        }

        $output = $browsershot->pdf();

        return response()->streamDownload(
            fn() => print($output),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function fromData(array $data): static
    {
        // format / paper size
        if (! empty($data['format'])) {
            $this->format = FileFormatEnum::from($data['format']);
        } elseif (! empty($data['format_width']) && ! empty($data['format_height'])) {
            $this->width  = (float) $data['format_width'];
            $this->height = (float) $data['format_height'];
        }

        // margins
        $this->margin_tp = (float) ($data['m_top'] ?? 0);
        $this->margin_rt = (float) ($data['m_right'] ?? 0);
        $this->margin_bt = (float) ($data['m_bottom'] ?? 0);
        $this->margin_lt = (float) ($data['m_left'] ?? 0);

        // options
        $this->scale      = max(0.1, min(2, (float) ($data['Scale'] ?? 1)));
        $this->background = (bool) ($data['show_background'] ?? true);
        $this->landscape  = (bool) ($data['landscape'] ?? false);
        $this->eager      = (bool) ($data['eager'] ?? true);

        // invoice/client/shipment info passed to blade view
        $this->invoice_data = [
            'invoice_number'           => $data['invoice_number'] ?? null,
            'invoice_date'             => $data['invoice_date'] ?? null,
            'invoice_due'              => $data['invoice_due'] ?? null,
            'due_penalty'              => $data['due_penalty'] ?? 0,
            'company_email'            => $data['company_email'] ?? null,
            'company_phone'            => $data['company_phone'] ?? null,
            'company_website'          => $data['company_website'] ?? null,
            'company_address'          => $data['company_address'] ?? null,
            'client_name'              => $data['client_name'] ?? null,
            'client_email'             => $data['client_email'] ?? null,
            'client_phone'             => $data['client_phone'] ?? null,
            'client_website'           => $data['client_website'] ?? null,
            'client_address'           => $data['client_address'] ?? null,
            'shipment_address'         => $data['shipment_address'] ?? null,
            'shipment_tracking_number' => $data['shipment_tracking_number'] ?? null,
        ];

        return $this;
    }
}
