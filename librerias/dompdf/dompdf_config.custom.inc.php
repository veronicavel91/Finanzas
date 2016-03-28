<?php
// Please refer to dompdf_config.inc.php for details on each configuration option.

//define("DOMPDF_TEMP_DIR", "/tmp");
//define("DOMPDF_FONT_DIR", DOMPDF_DIR."/lib/fonts/");
//define("DOMPDF_FONT_CACHE", DOMPDF_DIR."/lib/fonts/");
define("DOMPDF_UNICODE_ENABLED", true);
//define("DOMPDF_PDF_BACKEND", "PDFLib");
define("DOMPDF_DEFAULT_MEDIA_TYPE", "print");
define("DOMPDF_DEFAULT_PAPER_SIZE", "A4");
//define("DOMPDF_DEFAULT_FONT", "serif");
define("DOMPDF_DPI", 300);
define("DOMPDF_ENABLE_CSS_FLOAT", true);
//define("DOMPDF_ENABLE_JAVASCRIPT", false);
//define("DEBUGPNG", true);
//define("DEBUGKEEPTEMP", true);
//define("DEBUGCSS", true);
//define("DEBUG_LAYOUT", true);
//define("DEBUG_LAYOUT_LINES", false);
//define("DEBUG_LAYOUT_BLOCKS", false);
//define("DEBUG_LAYOUT_INLINE", false);
//define("DOMPDF_FONT_HEIGHT_RATIO", 1.0);
//define("DEBUG_LAYOUT_PADDINGBOX", false);
//define("DOMPDF_LOG_OUTPUT_FILE", DOMPDF_FONT_DIR."log.htm");
define("DOMPDF_ENABLE_HTML5PARSER", true);
define("DOMPDF_ENABLE_FONTSUBSETTING", true);

// Authentication for the dompdf/www
//define("DOMPDF_ADMIN_USERNAME", "sysbeto");
//define("DOMPDF_ADMIN_PASSWORD", "r3n3g4d3");

/**
 * Attention!
 * The following settings may increase the risk of system exploit.
 * Do not change these settings without understanding the consequences.
 * Additional documentation is available on the dompdf wiki at:
 * https://github.com/dompdf/dompdf/wiki
 */
//define("DOMPDF_CHROOT", DOMPDF_DIR);
define("DOMPDF_ENABLE_PHP", true);
//define("DOMPDF_ENABLE_REMOTE", false);
