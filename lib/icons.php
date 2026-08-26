<?php
/* =============================================================================
   Icon set — one stroked, 24x24, currentColor system.

   The site previously mixed platform emoji with three full-colour PNGs. Emoji
   render as a different drawing on every OS, cannot take a brand colour, and
   sit on their own baseline; the PNGs were 1.4 MB portraits shown at 50 px.
   These are drawn on one grid with one stroke weight so a sport icon in the
   agenda rail and a service icon in a card read as the same family, inherit
   text colour, and cost nothing to load.

   Usage:  icon('football')            -> inline <svg>, sized by font-size
           icon('football','sport-icon') -> extra class for the fixed-size slots
   ============================================================================= */

function icon_paths() {
  static $P = null;
  if ($P !== null) return $P;
  $P = [
    /* ---- sports ---- */
    'football'   => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5 8.6 10l1.3 4h4.2l1.3-4z"/><path d="M12 3v4.5M4.2 9.4 8.6 10M19.8 9.4 15.4 10M6.8 18.6 9.9 14M17.2 18.6 14.1 14"/>',
    'basketball' => '<circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/><path d="M5.6 5.6c3.6 3.6 3.6 9.2 0 12.8M18.4 5.6c-3.6 3.6-3.6 9.2 0 12.8"/>',
    'volleyball' => '<circle cx="12" cy="12" r="9"/><path d="M12 3c2.4 3.2 3 7.4 1.6 11.2M3.3 10.4c4 .6 7.6 3 9.6 6.4M20.5 14.6c-3.4-2.2-7.7-2.6-11.4-1"/>',
    'racket'     => '<ellipse cx="10" cy="9" rx="6" ry="7"/><path d="M6.5 6.2 13.5 12M13.5 6.2 6.5 12"/><path d="m14.4 14 5.1 6.4"/>',
    'target'     => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/><path d="M12 1.5v3M12 19.5v3M1.5 12h3M19.5 12h3"/>',
    'boxing'     => '<path d="M7 8.5A3.5 3.5 0 0 1 10.5 5h3A4.5 4.5 0 0 1 18 9.5v3a3 3 0 0 1-3 3H9.5a2.5 2.5 0 0 1-2.5-2.5z"/><path d="M7 10.5H5.8A1.8 1.8 0 0 0 4 12.3v.4a1.8 1.8 0 0 0 1.8 1.8H7"/><path d="M9 15.5V18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-2.5"/>',
    'martial'    => '<path d="M3 11h18v3H3z"/><path d="M8 14v5l-2.5-1.6L3 19l2-5M16 14v5l2.5-1.6L21 19l-2-5"/><path d="M9.5 11V8.5a2.5 2.5 0 0 1 5 0V11"/>',
    'running'    => '<circle cx="15.5" cy="4.6" r="1.9"/><path d="M13.6 9.2 9.8 11l-.9 4.2"/><path d="m13.6 9.2 3.6 2.1 1.1 3.6"/><path d="M8.9 15.2 6 18.4M17.2 11.3 20 10M11.4 10.3 7.8 8.6"/>',
    'cycling'    => '<circle cx="5.5" cy="16.5" r="3.6"/><circle cx="18.5" cy="16.5" r="3.6"/><path d="M5.5 16.5 10 8h4l4.5 8.5M10 8h5.5"/><circle cx="16" cy="4.6" r="1.6"/><path d="M9 16.5h5"/>',
    'obstacles'  => '<path d="M4 20V6M4 6h9l-1.6 2.4L13 11H4"/><path d="M17 20v-7M14 13h6"/><path d="M14 16.5h6"/>',
    'kayak'      => '<path d="M3 15.5c3.4 2.6 14.6 2.6 18 0"/><path d="M4.6 13.2c3.6 1.6 11.2 1.6 14.8 0"/><path d="M7 4.8 17 12.4M17 4.8 7 12.4"/>',
    'gamepad'    => '<rect x="2.5" y="7.5" width="19" height="10" rx="4.2"/><path d="M7 11v3M5.5 12.5h3"/><circle cx="16" cy="11.8" r="1"/><circle cx="18.4" cy="14" r="1"/>',
    'swim'       => '<path d="M3 17.5c1.6-1.4 3.2-1.4 4.8 0s3.2 1.4 4.8 0 3.2-1.4 4.8 0 2.6 1.2 3.6.4"/><circle cx="16" cy="6.4" r="1.8"/><path d="m6 12 4.6-3.2L14 11l-2.5 2"/>',

    /* ---- awards & status ---- */
    'trophy'     => '<path d="M7.5 4h9v5.5a4.5 4.5 0 0 1-9 0z"/><path d="M7.5 5.5H5A2 2 0 0 0 5 9.5h2M16.5 5.5H19a2 2 0 0 1 0 4h-2"/><path d="M12 14v3.5M9 20h6M9.6 17.5h4.8"/>',
    'star'       => '<path d="m12 3.6 2.7 5.6 6 .8-4.4 4.2 1.1 6.1L12 17.4l-5.4 2.9 1.1-6.1L3.3 10l6-.8z"/>',
    'medal'      => '<circle cx="12" cy="14.5" r="5.5"/><path d="M12 11.8l1.1 2.2 2.4.3-1.8 1.7.5 2.4-2.2-1.2-2.2 1.2.5-2.4-1.8-1.7 2.4-.3z"/><path d="M8.5 9 6 3.5h12L15.5 9"/>',
    'check'      => '<circle cx="12" cy="12" r="9"/><path d="m8 12.2 2.8 2.8L16 9.8"/>',
    'shield'     => '<path d="M12 3 5 5.8v5.4c0 4.2 2.9 7.6 7 9.3 4.1-1.7 7-5.1 7-9.3V5.8z"/><path d="m9 12 2.2 2.2L15.2 10"/>',

    /* ---- wayfinding & contact ---- */
    'pin'        => '<path d="M12 21s7-6 7-11a7 7 0 1 0-14 0c0 5 7 11 7 11z"/><circle cx="12" cy="10" r="2.6"/>',
    'map'        => '<path d="m3 6.5 6-2.5 6 2.5 6-2.5v13.5l-6 2.5-6-2.5-6 2.5z"/><path d="M9 4v13.5M15 6.5V20"/>',
    'phone'      => '<path d="M6.2 3.5h3l1.5 4-2 1.5a11.5 11.5 0 0 0 5.3 5.3l1.5-2 4 1.5v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4.2 5.7a2 2 0 0 1 2-2.2z"/>',
    'mail'       => '<rect x="3" y="5.5" width="18" height="13" rx="2.4"/><path d="m3.6 7 8.4 6 8.4-6"/>',
    'chat'       => '<path d="M20.5 12.2c0 4-3.8 7.2-8.5 7.2a10 10 0 0 1-2.8-.4L4 20.5l1.4-3.7A6.8 6.8 0 0 1 3.5 12.2C3.5 8.2 7.3 5 12 5s8.5 3.2 8.5 7.2z"/>',
    'clock'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.3l3.4 2"/>',
    'home'       => '<path d="M3.5 10.5 12 3.5l8.5 7"/><path d="M5.8 9.3V20h12.4V9.3"/><path d="M10 20v-5.5h4V20"/>',
    'calendar'   => '<rect x="3.5" y="5" width="17" height="15.5" rx="2.4"/><path d="M3.5 9.8h17M8.5 3v4M15.5 3v4"/>',
    'ticket'     => '<path d="M3.5 8.5A2 2 0 0 1 5.5 6.5h13a2 2 0 0 1 2 2v1.8a2 2 0 0 0 0 3.4v1.8a2 2 0 0 1-2 2h-13a2 2 0 0 1-2-2v-1.8a2 2 0 0 0 0-3.4z"/><path d="M14 6.5v11"/>',

    /* ---- people & services ---- */
    'users'      => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 19.5c0-3 2.5-5.2 5.5-5.2s5.5 2.2 5.5 5.2"/><path d="M16 5.4a3.2 3.2 0 0 1 0 6.2M17.2 14.6c2.1.6 3.6 2.4 3.6 4.9"/>',
    'family'     => '<circle cx="7.5" cy="7" r="2.6"/><circle cx="16.5" cy="7" r="2.6"/><path d="M3.5 19c0-2.6 1.8-4.4 4-4.4s4 1.8 4 4.4M12.5 19c0-2.6 1.8-4.4 4-4.4s4 1.8 4 4.4"/>',
    'grad'       => '<path d="m12 4 9 4.2-9 4.2-9-4.2z"/><path d="M6.5 10.4V15c0 1.6 2.5 2.8 5.5 2.8s5.5-1.2 5.5-2.8v-4.6"/><path d="M21 8.2V14"/>',
    'medical'    => '<path d="M6 3.5v5a4 4 0 0 0 8 0v-5"/><path d="M4.4 3.5h3M12.6 3.5h3"/><path d="M10 12.5v2.2a4.3 4.3 0 0 0 8.6 0V14"/><circle cx="18.6" cy="12.2" r="2"/>',
    'food'       => '<path d="M6 3.5v7M4 3.5v4a2 2 0 0 0 4 0v-4M6 10.5V20"/><path d="M17.5 3.5c-1.7 1-2.5 3-2.5 5.5s.8 3.5 2.5 3.5V20"/>',
    'shop'       => '<path d="M5 8h14l-1.2 11.2a1.6 1.6 0 0 1-1.6 1.3H7.8a1.6 1.6 0 0 1-1.6-1.3z"/><path d="M9 8V6.2a3 3 0 0 1 6 0V8"/>',
    'handshake'  => '<path d="M2.5 10.5h3l3-2.4h7l3 2.4h3"/><path d="M18.5 10.5v5.4h-3L12 18.4 8.5 15.9h-3v-5.4"/><path d="M8.5 12.4h7"/>',
    'volunteer'  => '<path d="M12 20.5S4.5 15.8 4.5 10.4A4.2 4.2 0 0 1 12 7.8a4.2 4.2 0 0 1 7.5 2.6c0 5.4-7.5 10.1-7.5 10.1z"/>',
    'stage'      => '<path d="M3 8.5h18M4.5 8.5V20h15V8.5"/><path d="m6 8.5 2.5-4.5h7L18 8.5"/><path d="M9.5 20v-5h5v5"/>',
    'palette'    => '<path d="M12 3.5a8.5 8.5 0 0 0 0 17c1.4 0 2-.9 2-1.8 0-1.4-1.2-1.7-1.2-2.9 0-.9.8-1.6 1.8-1.6h1.6a4.3 4.3 0 0 0 4.3-4.3c0-3.6-3.7-6.4-8.5-6.4z"/><circle cx="8" cy="9.5" r="1"/><circle cx="12" cy="7.5" r="1"/><circle cx="16" cy="9.5" r="1"/>',
    'wheel'      => '<circle cx="12" cy="10.5" r="7"/><path d="M12 3.5v14M5 10.5h14M7 5.5l10 10M17 5.5l-10 10"/><path d="M9.5 20.5h5L12 17.5z"/>',
    'clipboard'  => '<rect x="5" y="4.8" width="14" height="15.7" rx="2.2"/><path d="M9 4.8V3.6h6v1.2"/><path d="M8.8 10.5h6.4M8.8 14h6.4M8.8 17.2h3.6"/>',
    'news'       => '<path d="M3.5 5.5h13v14h-13z"/><path d="M16.5 9.5H20v8a2 2 0 0 1-3.5 1.3"/><path d="M6 8.8h8M6 12h8M6 15.2h5"/>',
    'bulb'       => '<path d="M9 16.5a6 6 0 1 1 6 0v1.8H9z"/><path d="M9.8 20.8h4.4"/>',
    'question'   => '<circle cx="12" cy="12" r="9"/><path d="M9.6 9.6a2.5 2.5 0 1 1 3.4 2.3c-.7.3-1 .9-1 1.6v.4"/><path d="M12 17.2h.01"/>',
    'close'      => '<path d="m6.5 6.5 11 11M17.5 6.5l-11 11"/>',
    'edit'       => '<path d="M4 20h4l10.5-10.5a2.1 2.1 0 0 0-3-3L5 17v3z"/><path d="m14 6 4 4"/>',
    'stadium'    => '<ellipse cx="12" cy="9" rx="9" ry="4.5"/><path d="M3 9v6c0 2.5 4 4.5 9 4.5s9-2 9-4.5V9"/><path d="M8.5 12.6v4.6M15.5 12.6v4.6"/>',
    'sparkle'    => '<path d="m12 3.5 1.9 4.6 4.6 1.9-4.6 1.9L12 16.5l-1.9-4.6L5.5 10l4.6-1.9z"/><path d="M18.5 15.5l.8 1.9 1.9.8-1.9.8-.8 1.9-.8-1.9-1.9-.8 1.9-.8z"/>',
  ];
  return $P;
}

/* Render one icon. $extra adds a class (e.g. 'sport-icon' for the fixed slots). */
function icon($name, $extra = '') {
  $P = icon_paths();
  if (!isset($P[$name])) $name = 'sparkle';
  $cls = 'ic-svg' . ($extra !== '' ? ' ' . $extra : '');
  return '<svg class="' . e($cls) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor"'
       . ' stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"'
       . ' aria-hidden="true" focusable="false">' . $P[$name] . '</svg>';
}
