$assets = @(
  '/css/fontawesome-compat.css',
  '/3rdparty/fontawesome/css/all.min.css',
  '/3rdparty/fontawesome/webfonts/fa-solid-900.woff2',
  '/3rdparty/jquery/jquery-3.7.1.min.js',
  '/3rdparty/jquery/jquery-migrate-3.5.0.min.js',
  '/3rdparty/bootstrap/css/bootstrap.min.css',
  '/3rdparty/bootstrap/css/bootstrap-3.4.1.min.css',
  '/3rdparty/bootstrap/js/bootstrap.min.js',
  '/3rdparty/moment/moment-2.31.0.min.js',
  '/3rdparty/moment/moment-2.31.0.min.js.map',
  '/css/holiday.css'
)
foreach ($port in @(8080,8081)) {
  "=== PORT $port ==="
  foreach ($a in $assets) {
    try { $r = Invoke-WebRequest -Uri "http://127.0.0.1:$port$a" -UseBasicParsing -TimeoutSec 15; "$($r.StatusCode) $a $($r.RawContentLength)" }
    catch { "ERR $a $($_.Exception.Message)" }
  }
  try {
    $d = Invoke-WebRequest -Uri "http://127.0.0.1:$port/diagnostic.php" -UseBasicParsing -TimeoutSec 20
    "diagnostic.php: $($d.StatusCode)"
    $ext = [regex]::Matches($d.Content, 'https://(cdnjs|code.jquery|maxcdn)[^"\s]+') | ForEach-Object { $_.Value }
    "external CDN refs in diagnostic: $($ext.Count)"
    $ext | Select-Object -First 5
  } catch { "diagnostic.php ERR $($_.Exception.Message)" }
}
