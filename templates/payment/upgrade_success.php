<?php
    $latest_invoice = \geomify\Processor\User::latest_stripe_invoice();
    $package        = \geomify\Schema\Schema::get( 'packages' )[geomify_var( 'package_name' )];
?>

<div class="upgrade-success">
    <div class="success-header">
        <div class="InvoiceThumbnail"><svg class="InlineSVG InvoiceThumbnail-image" focusable="false" width="131"
                height="145" viewBox="0 0 131 145" fill="none">
                <g filter="url(#filter0_ddd)">
                    <rect x="35" y="25" width="60.5902" height="74.8467" rx="4" fill="white"></rect>
                </g>
                <rect opacity="0.12" x="42.13" y="33.9097" width="10.6924" height="10.6924" rx="5.34619" fill="#191919">
                </rect>
                <rect opacity="0.1" x="58.1651" y="37.4744" width="14.2565" height="3.56413" rx="1.78206"
                    fill="#191919"></rect>
                <rect opacity="0.1" x="42.13" y="53.5132" width="10.6924" height="3.56413" rx="1.78206" fill="#191919">
                </rect>
                <rect opacity="0.1" x="42.13" y="62.4229" width="10.6924" height="3.56413" rx="1.78206" fill="#191919">
                </rect>
                <rect opacity="0.1" x="77.7701" y="85.5901" width="10.6924" height="3.56413" rx="1.78206"
                    fill="#191919"></rect>
                <rect opacity="0.1" x="58.1651" y="53.5132" width="19.6027" height="3.56413" rx="1.78206"
                    fill="#191919"></rect>
                <rect opacity="0.1" x="58.1651" y="62.4229" width="19.6027" height="3.56413" rx="1.78206"
                    fill="#191919"></rect>
                <rect opacity="0.1" x="42.13" y="85.5901" width="28.513" height="3.56413" rx="1.78206" fill="#191919">
                </rect>
                <rect opacity="0.05" x="42.13" y="76.6804" width="46.3337" height="3.56413" rx="1.78206" fill="#191919">
                </rect>
                <defs>
                    <filter id="filter0_ddd" x="0" y="0" width="130.59" height="144.847" filterUnits="userSpaceOnUse"
                        color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></feColorMatrix>
                        <feOffset dy="10"></feOffset>
                        <feGaussianBlur stdDeviation="17.5"></feGaussianBlur>
                        <feColorMatrix type="matrix"
                            values="0 0 0 0 0.207843 0 0 0 0 0.207843 0 0 0 0 0.207843 0 0 0 0.08 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend>
                        <feColorMatrix in="SourceAlpha" type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></feColorMatrix>
                        <feOffset dy="5"></feOffset>
                        <feGaussianBlur stdDeviation="7.5"></feGaussianBlur>
                        <feColorMatrix type="matrix"
                            values="0 0 0 0 0.208333 0 0 0 0 0.208333 0 0 0 0 0.208333 0 0 0 0.04 0"></feColorMatrix>
                        <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"></feBlend>
                        <feColorMatrix in="SourceAlpha" type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"></feColorMatrix>
                        <feOffset dy="1"></feOffset>
                        <feGaussianBlur stdDeviation="1.5"></feGaussianBlur>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0">
                        </feColorMatrix>
                        <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"></feBlend>
                    </filter>
                </defs>
            </svg>
            <div class="InvoiceThumbnail-successMark"><svg class="InlineSVG Icon Icon--md" focusable="false" height="16"
                    viewBox="0 0 16 16" width="16">
                    <path
                        d="m8 16c-4.418278 0-8-3.581722-8-8s3.581722-8 8-8 8 3.581722 8 8-3.581722 8-8 8zm3.0832728-11.00479172-4.0832728 4.09057816-1.79289322-1.79289322c-.39052429-.39052429-1.02368927-.39052429-1.41421356 0s-.39052429 1.02368927 0 1.41421356l2.5 2.50000002c.39052429.3905243 1.02368927.3905243 1.41421356 0l4.79037962-4.79768495c.3905243-.3905243.3905243-1.02368927 0-1.41421357-.3905243-.39052429-1.0236893-.39052429-1.4142136 0z"
                        fill-rule="evenodd"></path>
                </svg></div>
        </div>
        <h6>Invoice paid</h6>
        <h2><?php printf( '€ %s', $package['price'] )?></h2>
    </div>
    <table class="invoice-info">
        <tr>
            <td>Invoice number</td>
            <td><?php echo $latest_invoice->number ?></td>
        </tr>
        <tr>
            <td>Payment date</td>
            <td><?php echo date( 'F j, Y', $latest_invoice->status_transitions->paid_at ) ?></td>
        </tr>
    </table>
    <div class="invoice-buttons">
        <a href="<?php echo $latest_invoice->hosted_invoice_url ?>" class="geomify-form-submit-btn" target="_blank">View
            invioce</a>
        <a href="<?php echo $latest_invoice->invoice_pdf ?>" class="geomify-form-submit-btn" target="_blank">Download
            invioce</a>
    </div>
</div>