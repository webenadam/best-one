<?php
// Get SVG Icons
function svg_icon($icon_name, $icon_color = null, $flip = null, $width = null, $height = null)
{
    $flip_transform = '';

    // Determine the flip transformation based on the $flip parameter
    if ($flip === 'flip-h') {
        $flip_transform = 'scaleX(-1)';
    } elseif ($flip === 'flip-v') {
        $flip_transform = 'scaleY(-1)';
    }

    // Define default width and height values for each icon
    $default_dimensions = array(
        'place' => array('width' => 11, 'height' => 14),
        'link' => array('width' => 17, 'height' => 17),
        'left-arrow' => array('width' => 14, 'height' => 11),
        'circles' => array('width' => 105, 'height' => 91),
        'twirl' => array('width' => 22, 'height' => 72),
        'profile' => array('width' => 16, 'height' => 16),
        'dots' => array('width' => 107, 'height' => 109),
        'square' => array('width' => 202, 'height' => 202),
        'star' => array('width' => 22, 'height' => 22),
        'circle_check' => array('width' => 30, 'height' => 30),
        'circle_cross' => array('width' => 30, 'height' => 30), // Added new icon dimensions
        'trophy' => array('width' => 25, 'height' => 25),
        'share' => array('width' => 25, 'height' => 25),
        'facebook' => array('width' => 25, 'height' => 25),
        'twitter' => array('width' => 25, 'height' => 25),
        'linkedin' => array('width' => 25, 'height' => 25),
        'whatsapp' => array('width' => 25, 'height' => 25),
        'telegram' => array('width' => 25, 'height' => 25),
        'email' => array('width' => 25, 'height' => 25),
        'pinterest' => array('width' => 25, 'height' => 25),
        'reddit' => array('width' => 25, 'height' => 25),
        'hamburger' => array('width' => 30, 'height' => 30),

    );

    // Set width and height to provided values or default to original values
    $icon_width = $width ? $width : $default_dimensions[$icon_name]['width'];
    $icon_height = $height ? $height : $default_dimensions[$icon_name]['height'];

    $icons = array(
        'place' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: ' . $flip_transform . '">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.33333 0C2.71184 0 0 1.97836 0 5.28889C0 8.79978 4.90259 13.702 5.11153 13.9088C5.1702 13.9673 5.2502 14 5.33333 14C5.41647 14 5.49647 13.9673 5.55514 13.9088C5.76408 13.702 10.6667 8.79978 10.6667 5.28889C10.6667 1.97836 7.95482 0 5.33333 0ZM5.33548 7.15557C4.29736 7.15557 3.45312 6.31837 3.45312 5.28891C3.45312 4.25944 4.29736 3.42224 5.33548 3.42224C6.3736 3.42224 7.21783 4.25944 7.21783 5.28891C7.21783 6.31837 6.3736 7.15557 5.33548 7.15557Z" fill="' . ($icon_color ? $icon_color : '#68D585') . '"/>
        </svg>',
        'link' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: ' . $flip_transform . '">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.594645 1.36382C0.594645 0.926668 0.949413 0.571899 1.38657 0.571899H6.98415C7.42131 0.571899 7.77607 0.926668 7.77607 1.36382C7.77607 1.80097 7.42131 2.15574 6.98415 2.15574H3.29778L8.66375 7.52172C8.97324 7.83121 8.97324 8.33219 8.66375 8.64094C8.35426 8.95043 7.85329 8.95043 7.54454 8.64094L2.17856 3.27495V6.96134C2.17856 7.39849 1.82379 7.75325 1.38664 7.75325C0.949489 7.75325 0.594721 7.39849 0.594721 6.96134L0.594645 1.36382ZM11.8573 16.417H5.14192C4.50437 16.417 3.97891 16.417 3.55066 16.3821C3.10534 16.3457 2.69641 16.2678 2.3127 16.0718C1.71673 15.7683 1.23282 15.2836 0.928513 14.6876C0.732585 14.3032 0.654647 13.8942 0.618281 13.4497C0.583399 13.0214 0.583399 12.4952 0.583399 11.8577V11.2706C0.583399 10.8335 0.938167 10.4787 1.37532 10.4787C1.81247 10.4787 2.16724 10.8335 2.16724 11.2706V11.8251C2.16724 12.5034 2.16798 12.9643 2.19693 13.3206C2.22513 13.6679 2.27708 13.8453 2.34017 13.9692C2.49158 14.2669 2.73427 14.5096 3.03188 14.661C3.15583 14.724 3.3332 14.7753 3.68056 14.8042C4.03681 14.8331 4.49771 14.8339 5.17607 14.8339H11.8261C12.5044 14.8339 12.9653 14.8331 13.3216 14.8042C13.6689 14.776 13.8463 14.724 13.9703 14.661C14.2679 14.5095 14.5106 14.2669 14.662 13.9692C14.7251 13.8453 14.7763 13.6679 14.8045 13.3206C14.8334 12.9643 14.8342 12.5034 14.8342 11.8251V5.17505C14.8342 4.49669 14.8334 4.03579 14.8045 3.67954C14.7763 3.3322 14.7251 3.15482 14.662 3.03086C14.5098 2.73325 14.2679 2.49054 13.9703 2.33915C13.8463 2.27606 13.6689 2.22485 13.3216 2.19665C12.9653 2.1677 12.5044 2.16696 11.8261 2.16696H11.2717C10.8345 2.16696 10.4797 1.81219 10.4797 1.37504C10.4797 0.937889 10.8345 0.583121 11.2717 0.583121H11.8587C12.4963 0.583121 13.0217 0.583121 13.4507 0.618003C13.896 0.654371 14.305 0.732299 14.6887 0.928235C15.2846 1.2318 15.7693 1.71643 16.0729 2.31242C16.2688 2.69687 16.3467 3.10583 16.3831 3.55039C16.418 3.97863 16.418 4.50483 16.418 5.14238V11.8577C16.418 12.4953 16.418 13.0207 16.3831 13.4497C16.3467 13.8951 16.2688 14.304 16.0729 14.6877C15.7693 15.2837 15.2847 15.7683 14.6887 16.0719C14.3042 16.2678 13.8953 16.3457 13.4507 16.3821C13.0225 16.417 12.4963 16.417 11.8587 16.417L11.8573 16.417Z" fill="' . ($icon_color ? $icon_color : '#979797') . '"/>
        </svg>',
        'left-arrow' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: ' . $flip_transform . '">
        <path d="M16 7.99998L1 7.77776" stroke="' . ($icon_color ? $icon_color : '#68D585') . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M8 15L0.999999 8L8 1" stroke="' . ($icon_color ? $icon_color : '#68D585') . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>',
        'circles' => '<svg style="transform: ' . $flip_transform . '" width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 105 91" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.06572 56.7186C8.83762 75.0121 26.7625 88.139 48.0612 88.8827C77.2982 89.9037 101.821 67.2039 102.835 38.1813C103.232 26.7962 99.9529 16.1294 94.0554 7.30768L89.3915 9.78589C94.8756 17.8087 97.9371 27.5685 97.5729 37.9976C96.6601 64.136 74.5743 84.5799 48.2428 83.6604C28.8859 82.9844 12.6232 70.9518 5.72854 54.241L1.06572 56.7186Z" fill="#68D585"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2089 58.5338C23.1534 69.0314 34.9662 76.1411 48.5902 76.6169C70.8659 77.3948 89.5485 60.1432 90.3188 38.0843C90.8451 23.0128 82.8734 9.59658 70.6655 2.36133L66.9205 6.22431C78.1331 12.3565 85.5448 24.3609 85.0719 37.9011C84.4018 57.0905 68.1496 72.098 48.7715 71.4213C36.4839 70.9922 25.89 64.3599 19.9533 54.6714L16.2089 58.5338Z" fill="#161C2D"/>
        </svg>',
        'twirl' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 22 72" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: ' . $flip_transform . '">
        <mask id="mask0_0_3337" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="12" y="2" width="10" height="70">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8945 2.47369H22.0011V71.4448H12.8945V2.47369Z" fill="white"/>
        </mask>
        <g mask="url(#mask0_0_3337)">
        <path opacity="0.56" fill-rule="evenodd" clip-rule="evenodd" d="M12.8945 70.2524C12.8945 66.938 14.8807 65.2757 16.6307 63.8074C18.2449 62.4577 19.518 61.3924 19.518 59.1611C19.518 56.9284 18.2449 55.8631 16.6307 54.5104C14.8807 53.0436 12.8945 51.3813 12.8945 48.0654C12.8945 44.7526 14.8807 43.0902 16.6307 41.6234C18.2449 40.2737 19.518 39.207 19.518 36.9772C19.518 34.7444 18.2449 33.6776 16.6307 32.3264C14.8807 30.8582 12.8945 29.1958 12.8945 25.8785C12.8945 22.5612 14.8791 20.8959 16.6307 19.4276C18.2433 18.0764 19.518 17.0067 19.518 14.7724C19.518 12.5382 18.2433 11.47 16.6307 10.1187C14.8791 8.64899 12.8945 6.98515 12.8945 3.66637C12.8945 3.00854 13.4501 2.47369 14.1368 2.47369C14.822 2.47369 15.3776 3.00854 15.3776 3.66637C15.3776 5.90211 16.6523 6.97034 18.2649 8.32156C20.0165 9.78982 22.0011 11.4537 22.0011 14.7724C22.0011 18.0897 20.0165 19.7551 18.2634 21.2233C16.6523 22.576 15.3776 23.6442 15.3776 25.8785C15.3776 28.1113 16.6523 29.1795 18.2634 30.5292C20.0165 31.9975 22.0011 33.6599 22.0011 36.9772C22.0011 40.2915 20.0149 41.9538 18.2634 43.4206C16.6523 44.7704 15.3776 45.8371 15.3776 48.0654C15.3776 50.2982 16.6523 51.3635 18.2634 52.7147C20.0149 54.1815 22.0011 55.8453 22.0011 59.1611C22.0011 62.4755 20.0149 64.1393 18.2634 65.6061C16.6523 66.9558 15.3776 68.0226 15.3776 70.2524C15.3776 70.9102 14.822 71.4451 14.1368 71.4451C13.4501 71.4451 12.8945 70.9102 12.8945 70.2524Z" fill="#F64B4B"/>
        </g>
        <path opacity="0.56" fill-rule="evenodd" clip-rule="evenodd" d="M0.207031 69.0271C0.207031 65.6947 2.17071 64.024 3.90095 62.5499C5.49539 61.1934 6.75569 60.1228 6.75569 57.8804C6.75569 55.6364 5.49539 54.5643 3.90095 53.2064C2.17071 51.7322 0.207031 50.0616 0.207031 46.7292C0.207031 43.3983 2.17071 41.7291 3.90095 40.2535C5.49539 38.8985 6.75569 37.8264 6.75569 35.5854C6.75569 33.3415 5.49539 32.2679 3.90095 30.91C2.17071 29.4358 0.207031 27.7637 0.207031 24.4313C0.207031 21.0959 2.16919 19.4237 3.89943 17.9481C5.49539 16.5887 6.75569 15.5151 6.75569 13.2697C6.75569 11.0228 5.49539 9.95068 3.90095 8.59122C2.16919 7.11561 0.207031 5.44196 0.207031 2.10808C0.207031 1.44547 0.756313 0.909424 1.43376 0.909424C2.11273 0.909424 2.66202 1.44547 2.66202 2.10808C2.66202 4.3535 3.92231 5.42707 5.51675 6.78654C7.24852 8.26215 9.20915 9.9343 9.20915 13.2697C9.20915 16.6036 7.24852 18.2772 5.51523 19.7528C3.92231 21.1123 2.66202 22.1859 2.66202 24.4313C2.66202 26.6752 3.92231 27.7473 5.51523 29.1053C7.24852 30.5794 9.20915 32.2516 9.20915 35.5854C9.20915 38.9164 7.24699 40.5855 5.51523 42.0611C3.92079 43.4176 2.66202 44.4882 2.66202 46.7292C2.66202 48.9716 3.92079 50.0437 5.51523 51.4017C7.24699 52.8758 9.20915 54.548 9.20915 57.8804C9.20915 61.2113 7.24699 62.8834 5.51523 64.3561C3.92079 65.7125 2.66202 66.7846 2.66202 69.0271C2.66202 69.6882 2.11273 70.2257 1.43376 70.2257C0.756313 70.2257 0.207031 69.6882 0.207031 69.0271Z" fill="#F64B4B"/>
        </svg>',
        'profile' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 16 16" style="transform: ' . $flip_transform . '"><g fill="' . ($icon_color ? $icon_color : '#ffffff') . '"><circle cx="8" cy="8" r="7.5" fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round"></circle><path d="M8,3.5h0c1.381,0,2.5,1.119,2.5,2.5v1c0,1.381-1.119,2.5-2.5,2.5h0c-1.381,0-2.5-1.119-2.5-2.5v-1c0-1.381,1.119-2.5,2.5-2.5Z" fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4.031,12.06l1.821-.676c.309-.115,.541-.374,.622-.693l.372-1.477" fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.969,12.06l-1.821-.676c-.309-.115-.541-.374-.622-.693l-.372-1.477" fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>',
        'dots' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 107 109" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: ' . $flip_transform . '">
        <path opacity="0.797991" fill-rule="evenodd" clip-rule="evenodd" d="M70.5034 104H70.4898C69.9123 104 69.4058 104.229 68.9841 104.558C68.9028 104.623 68.8012 104.66 68.7283 104.733C68.3235 105.14 68.0898 105.697 68.039 106.304C68.0339 106.372 68 106.431 68 106.501C68 106.81 68.0728 107.098 68.1762 107.37C68.21 107.458 68.2524 107.534 68.2947 107.617C68.3862 107.795 68.4963 107.96 68.6284 108.111C68.6927 108.186 68.7503 108.262 68.8232 108.328C69.023 108.51 69.2432 108.669 69.4939 108.779H69.4956C69.8056 108.917 70.1443 109 70.5034 109C71.6162 109 72.5257 108.26 72.8493 107.251C72.9356 107.02 72.9949 106.779 72.9966 106.514C72.9966 106.509 73 106.506 73 106.501C73 105.118 71.8821 104 70.5034 104ZM105.43 74.1883C105.188 74.0865 104.918 74.0475 104.642 74.0288C104.593 74.0271 104.554 74 104.503 74H104.49C103.111 74 102 75.1194 102 76.5017C102 76.8375 102.071 77.1547 102.191 77.443C102.276 77.6499 102.415 77.8161 102.545 77.9908C102.6 78.057 102.63 78.1384 102.688 78.1995C103.103 78.6404 103.675 78.9118 104.315 78.9627C104.319 78.9627 104.322 78.9644 104.326 78.9661V78.9644C104.387 78.9695 104.441 79 104.503 79C105.882 79 107 77.8806 107 76.5017C107 75.4501 106.348 74.558 105.43 74.1883ZM19.5034 30H19.4898C18.1111 30 17 31.1194 17 32.5C17 33.8789 18.1247 35 19.5034 35C20.8804 35 22 33.8789 22 32.5C22 31.1194 20.8804 30 19.5034 30ZM19.5034 89H19.4898C18.1111 89 17 90.1181 17 91.5008C17 92.8802 18.1247 94 19.5034 94C20.8804 94 22 92.8802 22 91.5008C22 90.1181 20.8804 89 19.5034 89ZM36.5034 50C37.8821 50 39 48.8789 39 47.5C39 46.1177 37.8821 45 36.5034 45H36.4915C35.1111 45 34 46.1177 34 47.5C34 48.8789 35.1247 50 36.5034 50ZM19.5034 15H19.4898C18.1111 15 17 16.1194 17 17.5C17 18.8806 18.1247 20 19.5034 20C20.8804 20 22 18.8806 22 17.5C22 16.1194 20.8804 15 19.5034 15ZM19.5034 59H19.4898C18.1111 59 17 60.1194 17 61.5C17 62.8806 18.1247 64 19.5034 64C20.8804 64 22 62.8806 22 61.5C22 60.1194 20.8804 59 19.5034 59ZM19.5034 74H19.4898C18.1111 74 17 75.1194 17 76.5017C17 77.8806 18.1247 79 19.5034 79C20.8804 79 22 77.8806 22 76.5017C22 75.1194 20.8804 74 19.5034 74ZM36.5034 20C37.8821 20 39 18.8806 39 17.5C39 16.1194 37.8821 15 36.5034 15H36.4915C35.1111 15 34 16.1194 34 17.5C34 18.8806 35.1247 20 36.5034 20ZM36.5034 35C37.8821 35 39 33.8789 39 32.5C39 31.1194 37.8821 30 36.5034 30H36.4915C35.1111 30 34 31.1194 34 32.5C34 33.8789 35.1247 35 36.5034 35ZM36.5034 5C37.8821 5 39 3.8806 39 2.5C39 1.1194 37.8821 0 36.5034 0H36.4915C35.1111 0 34 1.1194 34 2.5C34 3.8806 35.1247 5 36.5034 5ZM19.5034 45H19.4898C18.1111 45 17 46.1177 17 47.5C17 48.8789 18.1247 50 19.5034 50C20.8804 50 22 48.8789 22 47.5C22 46.1177 20.8804 45 19.5034 45ZM2.50508 59H2.48984C1.11111 59 0 60.1194 0 61.5C0 62.8806 1.12636 64 2.50508 64C3.88381 64 5 62.8806 5 61.5C5 60.1194 3.88381 59 2.50508 59ZM2.50508 45H2.48984C1.11111 45 0 46.1177 0 47.5C0 48.8789 1.12636 50 2.50508 50C3.88381 50 5 48.8789 5 47.5C5 46.1177 3.88381 45 2.50508 45ZM2.50424 74H2.48899C2.17553 74 1.88241 74.0712 1.60962 74.1798C1.47069 74.2324 1.35547 74.3172 1.23009 74.3935C1.12504 74.4596 1.0183 74.519 0.923416 74.6021C0.759065 74.7361 0.630295 74.8921 0.504914 75.0651C0.481193 75.1007 0.457472 75.133 0.433751 75.172C0.298204 75.3823 0.198238 75.6028 0.130464 75.8504L0.12877 75.8521V75.8538C0.0711623 76.0641 0 76.271 0 76.5017C0 77.4854 0.584548 78.3182 1.41308 78.7252V78.7269H1.41477C1.74517 78.8881 2.10098 78.9949 2.49068 78.9966C2.49576 78.9966 2.49915 79 2.50424 79C3.88343 79 5 77.8806 5 76.5017C5 76.1557 4.93053 75.8267 4.80346 75.5282C4.42562 74.6309 3.53778 74 2.50424 74ZM87.5034 45H87.4898C86.1111 45 85 46.1177 85 47.5C85 48.8789 86.1247 50 87.5034 50C88.8821 50 90 48.8789 90 47.5C90 46.1177 88.8821 45 87.5034 45ZM2.50424 30H2.48899C2.20434 30 1.94171 30.0628 1.69434 30.1611C1.46899 30.2391 1.27245 30.3562 1.08268 30.4919C1.08099 30.4919 1.08099 30.4919 1.0793 30.4936C0.440529 30.9464 0 31.6554 0 32.5C0 32.6069 0.0474415 32.6967 0.0609963 32.8019H0.0593019C0.0593019 32.8053 0.0609963 32.807 0.0626906 32.8087C0.14063 33.4176 0.413419 33.9552 0.848865 34.3453C0.908167 34.3996 0.982718 34.4301 1.04541 34.4776C1.21654 34.6031 1.38089 34.7337 1.58251 34.8134C1.86547 34.9305 2.17384 35 2.50424 35C3.53778 35 4.42562 34.3708 4.80346 33.4718C4.93053 33.1733 5 32.8443 5 32.5C5 32.1557 4.93053 31.8267 4.80346 31.5282C4.42562 30.6292 3.53778 30 2.50424 30ZM87.5034 59H87.4898C86.1111 59 85 60.1194 85 61.5C85 62.8806 86.1247 64 87.5034 64C88.8821 64 90 62.8806 90 61.5C90 60.1194 88.8821 59 87.5034 59ZM87.5034 30H87.4898C86.1111 30 85 31.1194 85 32.5C85 33.8789 86.1247 35 87.5034 35C88.8821 35 90 33.8789 90 32.5C90 31.1194 88.8821 30 87.5034 30ZM87.5034 89H87.4898C86.1111 89 85 90.1181 85 91.5008C85 92.8802 86.1247 94 87.5034 94C88.8821 94 90 92.8802 90 91.5008C90 90.1181 88.8821 89 87.5034 89ZM87.5034 74H87.4898C86.1111 74 85 75.1194 85 76.5017C85 77.8806 86.1247 79 87.5034 79C88.8821 79 90 77.8806 90 76.5017C90 75.1194 88.8821 74 87.5034 74ZM70.5042 5C71.8825 5 73 3.8806 73 2.5C73 2.5 72.9983 2.4983 72.9983 2.49661C72.9983 2.09125 72.8798 1.7232 72.7071 1.38399C72.6901 1.35176 72.6681 1.32802 72.6495 1.29749C72.4683 0.976934 72.2211 0.710651 71.9214 0.496947H71.9197C71.5117 0.20692 71.041 0 70.5042 0H70.4907C69.1124 0 68 1.1194 68 2.5C68 3.8806 69.126 5 70.5042 5ZM87.5034 15H87.4898C86.1111 15 85 16.1194 85 17.5C85 18.8806 86.1247 20 87.5034 20C88.8821 20 90 18.8806 90 17.5C90 16.1194 88.8821 15 87.5034 15ZM70.5034 30H70.4898C69.1111 30 68 31.1194 68 32.5C68 33.8789 69.1247 35 70.5034 35C71.8821 35 73 33.8789 73 32.5C73 31.1194 71.8821 30 70.5034 30ZM70.5034 74H70.4898C69.1111 74 68 75.1194 68 76.5017C68 77.8806 69.1247 79 70.5034 79C71.8821 79 73 77.8806 73 76.5017C73 75.1194 71.8821 74 70.5034 74ZM70.5034 59H70.4898C69.1111 59 68 60.1194 68 61.5C68 62.8806 69.1247 64 70.5034 64C71.8821 64 73 62.8806 73 61.5C73 60.1194 71.8821 59 70.5034 59ZM70.5034 45H70.4898C69.1111 45 68 46.1177 68 47.5C68 48.8789 69.1247 50 70.5034 50C71.8821 50 73 48.8789 73 47.5C73 46.1177 71.8821 45 70.5034 45ZM70.5034 89H70.4898C69.1111 89 68 90.1181 68 91.5008C68 92.8802 69.1247 94 70.5034 94C71.8821 94 73 92.8802 73 91.5008C73 90.1181 71.8821 89 70.5034 89ZM36.5034 64C37.8821 64 39 62.8806 39 61.5C39 60.1194 37.8821 59 36.5034 59H36.4915C35.1111 59 34 60.1194 34 61.5C34 62.8806 35.1247 64 36.5034 64ZM38.2683 104.733C38.1938 104.658 38.0921 104.621 38.0091 104.558C37.5874 104.229 37.081 104 36.5034 104H36.4898C35.1111 104 34 105.118 34 106.501C34 107.18 34.2761 107.79 34.7165 108.242C34.7182 108.243 34.7182 108.245 34.7199 108.245C35.1738 108.71 35.8039 109 36.5034 109C36.6355 109 36.749 108.946 36.876 108.925C36.8777 108.925 36.8794 108.924 36.8811 108.924C37.4705 108.832 37.9854 108.561 38.3598 108.131C38.4207 108.065 38.4563 107.984 38.5088 107.911C38.6223 107.75 38.7425 107.597 38.8171 107.412C38.9289 107.135 38.9949 106.833 38.9966 106.511C38.9966 106.508 39 106.506 39 106.501C39 105.866 38.7442 105.303 38.3564 104.862C38.3208 104.821 38.3056 104.769 38.2683 104.733ZM103.53 34.8033C103.83 34.9305 104.159 35 104.504 35C104.869 35 105.209 34.9135 105.521 34.7728C105.531 34.7677 105.538 34.7592 105.548 34.7542C105.853 34.6117 106.116 34.4117 106.338 34.1641C106.741 33.7216 107 33.1451 107 32.5008C107 31.1207 105.882 30 104.504 30H104.491C103.111 30 102 31.1207 102 32.5008C102 33.5351 102.632 34.4235 103.53 34.8033ZM104.504 50C105.882 50 107 48.8789 107 47.5C107 46.1177 105.882 45 104.504 45H104.491C103.111 45 102 46.1177 102 47.5C102 48.8789 103.123 50 104.504 50ZM104.504 64C105.882 64 107 62.8806 107 61.5C107 60.1194 105.882 59 104.504 59H104.491C103.111 59 102 60.1194 102 61.5C102 62.8806 103.123 64 104.504 64ZM53.5034 30H53.4915C52.1128 30 51 31.1194 51 32.5C51 33.8789 52.1247 35 53.5034 35C54.8821 35 56 33.8789 56 32.5C56 31.1194 54.8821 30 53.5034 30ZM53.5034 15H53.4915C52.1128 15 51 16.1194 51 17.5C51 18.8806 52.1247 20 53.5034 20C54.8821 20 56 18.8806 56 17.5C56 16.1194 54.8821 15 53.5034 15ZM53.5034 0H53.4915C52.1128 0 51 1.1194 51 2.5C51 3.8806 52.1247 5 53.5034 5C54.8821 5 56 3.8806 56 2.5C56 1.1194 54.8821 0 53.5034 0ZM36.5034 94C37.8821 94 39 92.8802 39 91.5008C39 90.1181 37.8821 89 36.5034 89H36.4915C35.1111 89 34 90.1181 34 91.5008C34 92.8802 35.1247 94 36.5034 94ZM36.5034 79C37.8821 79 39 77.8806 39 76.5017C39 75.1194 37.8821 74 36.5034 74H36.4915C35.1111 74 34 75.1194 34 76.5017C34 77.8806 35.1247 79 36.5034 79ZM53.5034 45H53.4915C52.1128 45 51 46.1177 51 47.5C51 48.8789 52.1247 50 53.5034 50C54.8821 50 56 48.8789 56 47.5C56 46.1177 54.8821 45 53.5034 45ZM70.5034 15H70.4898C69.1111 15 68 16.1194 68 17.5C68 18.8806 69.1247 20 70.5034 20C71.8821 20 73 18.8806 73 17.5C73 16.1194 71.8821 15 70.5034 15ZM53.5034 89H53.4915C52.1128 89 51 90.1181 51 91.5008C51 92.8802 52.1247 94 53.5034 94C54.8821 94 56 92.8802 56 91.5008C56 90.1181 54.8821 89 53.5034 89ZM53.5034 104H53.4915C52.1128 104 51 105.12 51 106.501C51 107.882 52.1247 109 53.5034 109C54.8821 109 56 107.882 56 106.501C56 105.12 54.8821 104 53.5034 104ZM53.5034 74H53.4915C52.1128 74 51 75.1194 51 76.5017C51 77.8806 52.1247 79 53.5034 79C54.8821 79 56 77.8806 56 76.5017C56 75.1194 54.8821 74 53.5034 74ZM53.5034 59H53.4915C52.1128 59 51 60.1194 51 61.5C51 62.8806 52.1247 64 53.5034 64C54.8821 64 56 62.8806 56 61.5C56 60.1194 54.8821 59 53.5034 59Z" fill="' . ($icon_color ? $icon_color : '#161C2D') . '" />
        </svg>',
        'square' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 202 202" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect y="35.345" width="170" height="170" rx="30" transform="rotate(-12 0 35.345)" stroke="' . ($icon_color ? $icon_color : '#68D585') . '" stroke-width="10"/>
        </svg>',
        'star' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M21.6559 7.88159H13.7121L11.3286 0.215524C11.2392 -0.0718414 10.7614 -0.0718414 10.6721 0.215524L8.2879 7.88159H0.344096C0.195601 7.88159 0.0642925 7.97646 0.017544 8.11739C-0.0292044 8.25833 0.0196065 8.41301 0.13854 8.50169L6.45371 13.1958L3.96985 20.8399C3.92379 20.9815 3.97398 21.1368 4.09497 21.2242C4.21597 21.3122 4.37822 21.3122 4.49921 21.2242L11 16.5012L17.5008 21.2242C17.5613 21.2682 17.6321 21.2902 17.7029 21.2902C17.7737 21.2902 17.8445 21.2682 17.905 21.2242C18.0253 21.1368 18.0762 20.9815 18.0301 20.8399L15.5463 13.1958L21.8615 8.50169C21.9804 8.41301 22.0292 8.25833 21.9825 8.11739C21.9357 7.97646 21.8044 7.88159 21.6559 7.88159Z" fill="' . ($icon_color ? $icon_color : '#68D585') . '"/>
        </svg>',
        'circle_check' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="15" cy="15" r="15" fill="' . ($icon_color ? $icon_color : '#68D585') . '"/>
    <path d="M13.1117 19.6923C12.87 19.6923 12.6287 19.6016 12.4442 19.4196L8 15.039L9.33504 13.7226L13.1117 17.4452L20.665 10L22 11.3164L13.7792 19.4196C13.5946 19.6016 13.3534 19.6923 13.1117 19.6923Z" fill="white"/>
</svg>',
        'trophy' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="16" cy="16" r="16" fill="' . ($icon_color ? $icon_color : '#56CD5D') . '"/>
<path d="M23.4531 8.6875H21.3438V7.84375C21.3438 7.76916 21.3141 7.69762 21.2614 7.64488C21.2086 7.59213 21.1371 7.5625 21.0625 7.5625H10.9375C10.8629 7.5625 10.7914 7.59213 10.7386 7.64488C10.6859 7.69762 10.6562 7.76916 10.6562 7.84375V8.6875H8.54688C8.43499 8.6875 8.32768 8.73195 8.24856 8.81106C8.16945 8.89018 8.125 8.99749 8.125 9.10938V11.9219C8.125 13.5981 9.124 15.2893 11.032 15.4243C11.4235 16.423 12.107 17.2805 12.9932 17.885C13.8794 18.4894 14.9273 18.8127 16 18.8127C17.0727 18.8127 18.1206 18.4894 19.0068 17.885C19.893 17.2805 20.5765 16.423 20.968 15.4243C22.876 15.2893 23.875 13.5981 23.875 11.9219V9.10938C23.875 8.99749 23.8306 8.89018 23.7514 8.81106C23.6723 8.73195 23.565 8.6875 23.4531 8.6875ZM8.96875 11.9219V9.53125H10.6562V13.4688C10.6562 13.8282 10.6924 14.1867 10.7642 14.5389C9.53547 14.2743 8.96875 13.0607 8.96875 11.9219ZM23.0312 11.9219C23.0312 13.0607 22.4645 14.2743 21.2358 14.5389C21.3076 14.1867 21.3438 13.8282 21.3438 13.4688V9.53125H23.0312V11.9219Z" fill="white"/>
<path d="M17.125 21.625H16.5625V19.375H15.4375V21.625H14.875C12.0043 21.625 11.7812 23.5625 11.7812 24.1562C11.7812 24.2308 11.8109 24.3024 11.8636 24.3551C11.9164 24.4079 11.9879 24.4375 12.0625 24.4375H19.9375C20.0121 24.4375 20.0836 24.4079 20.1364 24.3551C20.1891 24.3024 20.2188 24.2308 20.2188 24.1562C20.2188 23.5625 19.9957 21.625 17.125 21.625Z" fill="white"/>
</svg>',
        'circle_cross' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<g fill="' . ($icon_color ? $icon_color : '#FB6D45') . '">
<path d="M24,1C11.297,1,1,11.297,1,24s10.297,23,23,23,23-10.297,23-23S36.703,1,24,1Zm9.193,29.364c.391,.391,.391,1.024,0,1.414l-1.415,1.415c-.391,.391-1.024,.391-1.414,0l-6.364-6.365-6.364,6.365c-.391,.391-1.024,.391-1.414,0l-1.415-1.415c-.391-.391-.391-1.024,0-1.414l6.365-6.364-6.365-6.364c-.391-.391-.391-1.024,0-1.414l1.415-1.415c.391-.391,1.024-.391,1.414,0l6.364,6.365,6.364-6.365c.391-.391,1.024-.391,1.414,0l1.415,1.415c.391,.391,.391,1.024,0,1.414l-6.365,6.364,6.365,6.364Z" fill="' . ($icon_color ? $icon_color : '#FB6D45') . '"></path>
</g>
</svg>',
        'share' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g fill="' . ($icon_color ? $icon_color : '#ffffff') . '">
<line fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round" x1="6.12" y1="6.675" x2="9.881" y2="4.325"></line>
<line fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round" x1="6.12" y1="9.325" x2="9.881" y2="11.675"></line>
<circle fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round" cx="12" cy="3" r="2.5"></circle>
<circle fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round" cx="12" cy="13" r="2.5"></circle>
<circle fill="none" stroke="' . ($icon_color ? $icon_color : '#ffffff') . '" stroke-linecap="round" stroke-linejoin="round" cx="4" cy="8" r="2.5"></circle>
</g>
</svg>',

        'facebook' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22.675 0H1.325C0.595 0 0 0.595 0 1.325V22.675C0 23.405 0.595 24 1.325 24H12.82V14.706H9.692V11.24H12.82V8.745C12.82 5.841 14.67 4.204 17.237 4.204C18.483 4.204 19.791 4.391 19.791 4.391V7.435H18.082C16.399 7.435 16.18 8.258 16.18 9.252V11.24H19.658L19.146 14.706H16.18V24H22.675C23.405 24 24 23.405 24 22.675V1.325C24 0.595 23.405 0 22.675 0Z" fill="#ffffff"/>
</svg>',
        'twitter' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M23.953 4.57C23.162 4.95 22.332 5.2 21.478 5.308C22.345 4.725 23.002 3.888 23.338 2.916C22.508 3.392 21.605 3.772 20.662 4.002C19.865 3.193 18.728 2.75 17.515 2.75C14.935 2.75 12.924 4.761 12.924 7.341C12.924 7.68 12.965 8.007 13.046 8.314C8.65 8.091 4.805 6.136 2.059 3.146C1.612 3.802 1.356 4.57 1.356 5.393C1.356 6.889 2.187 8.206 3.388 8.896C2.642 8.875 1.934 8.671 1.32 8.322C1.32 8.34 1.32 8.359 1.32 8.377C1.32 10.523 2.895 12.276 5.004 12.688C4.596 12.808 4.152 12.873 3.688 12.873C3.344 12.873 3.012 12.842 2.686 12.786C3.364 14.507 5.009 15.754 6.938 15.787C5.383 16.916 3.42 17.588 1.356 17.588C0.906 17.588 0.461 17.56 0 17.5C1.937 18.719 4.24 19.5 6.75 19.5C17.515 19.5 22.74 12 22.74 7.767C22.74 7.58 22.74 7.391 22.726 7.206C23.562 6.638 24.303 5.917 24.953 5.07L23.953 4.57Z" fill="#ffffff"/>
</svg>',
        'linkedin' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22.23 0H1.77C0.79 0 0 0.77 0 1.72V22.27C0 23.23 0.79 24 1.77 24H22.23C23.21 24 24 23.23 24 22.27V1.72C24 0.77 23.21 0 22.23 0ZM7.08 20.45H3.56V9H7.08V20.45ZM5.32 7.56C4.24 7.56 3.35 6.67 3.35 5.59C3.35 4.52 4.24 3.63 5.32 3.63C6.4 3.63 7.29 4.52 7.29 5.59C7.29 6.67 6.4 7.56 5.32 7.56ZM20.45 20.45H16.93V14.77C16.93 13.8 16.91 12.57 15.75 12.57C14.59 12.57 14.39 13.63 14.39 14.67V20.45H10.86V9H14.25V10.28H14.3C14.76 9.45 15.83 8.74 17.28 8.74C20.12 8.74 20.45 10.69 20.45 13.08V20.45Z" fill="#ffffff"/>
</svg>',
       'whatsapp' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.021 2.049C8.295 2.049 2.049 8.296 2.049 16.022c0 3.14 1.035 6.043 2.792 8.408L2 30l5.755-2.788a13.924 13.924 0 0 0 8.266 2.64c7.726 0 13.972-6.247 13.972-13.973 0-7.727-6.246-13.973-13.972-13.973zm8.095 20.182c-.335.945-1.92 1.801-2.63 1.913-.682.105-1.545.145-2.48-.159a22.416 22.416 0 0 1-1.806-.635c-3.178-1.387-5.253-4.812-5.41-5.03-.155-.218-1.292-1.72-1.292-3.285 0-1.563.818-2.34 1.11-2.656.29-.317.635-.398.845-.398.211 0 .422 0 .602.01.19.008.448-.072.702.533.278.662.944 2.29 1.026 2.453.08.163.135.347.03.561-.105.213-.155.347-.31.535-.155.19-.327.422-.468.563-.155.155-.317.327-.136.626.182.29.808 1.335 1.732 2.162 1.19 1.06 2.194 1.39 2.485 1.547.31.155.482.135.66-.083.19-.218.759-.88.962-1.184.201-.317.403-.265.671-.155.275.11 1.742.82 2.044.968.303.145.503.218.58.34.075.11.075.878-.26 1.823z" fill="#ffffff"/>
</svg>',


        'telegram' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.636 16.84L9.116 21.443C9.636 21.443 9.876 21.201 10.116 20.961L13.192 18.12L18.404 21.14C19.244 21.619 19.792 21.4 19.996 20.417L22.875 6.423C23.139 5.225 22.468 4.762 21.676 5.055L2.816 11.683C1.69 12.097 1.701 12.708 2.637 12.985L7.76 14.485L18.18 8.25C18.772 7.936 19.292 8.124 18.832 8.438L9.636 16.84Z" fill="#ffffff"/>
</svg>',
        'email' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.5 3H3.5C2.39543 3 1.5 3.89543 1.5 5V19C1.5 20.1046 2.39543 21 3.5 21H20.5C21.6046 21 22.5 20.1046 22.5 19V5C22.5 3.89543 21.6046 3 20.5 3ZM20.5 5V5.01L12 11L3.5 5.01V5H20.5ZM3.5 19V7.84L12 14L20.5 7.84V19H3.5Z" fill="#ffffff"/>
</svg>',
'hamburger' => '<svg width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path class="line line1" d="M3 6H21V8H3V6Z" fill="' . ($icon_color ? $icon_color : '#161C2D') . '"/>
<path class="line line2" d="M3 11H21V13H3V11Z" fill="' . ($icon_color ? $icon_color : '#161C2D') . '"/>
<path class="line line3" d="M3 16H21V18H3V16Z" fill="' . ($icon_color ? $icon_color : '#161C2D') . '"/>
</svg>',


    );

    return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
}
