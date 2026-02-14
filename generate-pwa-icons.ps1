# Script para generar iconos PWA en diferentes tamaños
# Requiere ImageMagick instalado

# Colores
$Green = "Green"
$Red = "Red"
$Yellow = "Yellow"
$NC = "White" # No Color

Write-Host "========================================" -ForegroundColor $Yellow
Write-Host "  Generador de Iconos PWA - MC Studies" -ForegroundColor $Yellow
Write-Host "========================================" -ForegroundColor $Yellow
Write-Host ""

# Verificar si ImageMagick está instalado
try {
    $magickVersion = magick -version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ ImageMagick detectado" -ForegroundColor $Green
    } else {
        throw "ImageMagick no encontrado"
    }
} catch {
    Write-Host "❌ Error: ImageMagick no está instalado" -ForegroundColor $Red
    Write-Host ""
    Write-Host "Por favor, instala ImageMagick desde:" -ForegroundColor $Yellow
    Write-Host "https://imagemagick.org/script/download.php#windows" -ForegroundColor $Yellow
    Write-Host ""
    Write-Host "O usando chocolatey:" -ForegroundColor $Yellow
    Write-Host "choco install imagemagick" -ForegroundColor $Yellow
    exit 1
}

# Configuración
$sourceIcon = "public\Logo.png"
$outputDir = "public\icons"

# Verificar que existe el icono fuente
if (-not (Test-Path $sourceIcon)) {
    Write-Host "❌ Error: No se encuentra $sourceIcon" -ForegroundColor $Red
    exit 1
}

Write-Host "📁 Icono fuente: $sourceIcon" -ForegroundColor $Green
Write-Host ""

# Crear directorio de salida si no existe
if (-not (Test-Path $outputDir)) {
    New-Item -ItemType Directory -Path $outputDir | Out-Null
    Write-Host "📂 Creado directorio: $outputDir" -ForegroundColor $Green
}

# Tamaños de iconos para PWA
$sizes = @(72, 96, 128, 144, 152, 192, 384, 512)

Write-Host ""
Write-Host "🎨 Generando iconos..." -ForegroundColor $Yellow
Write-Host ""

foreach ($size in $sizes) {
    $output = "$outputDir\icon-${size}x${size}.png"
    
    try {
        # Generar icono redimensionado
        magick convert "$sourceIcon" -resize "${size}x${size}" "$output"
        
        if (Test-Path $output) {
            $fileSize = (Get-Item $output).Length
            $fileSizeKB = [math]::Round($fileSize / 1KB, 2)
            Write-Host "  ✅ ${size}x${size} → $output ($fileSizeKB KB)" -ForegroundColor $Green
        } else {
            Write-Host "  ❌ Error al generar ${size}x${size}" -ForegroundColor $Red
        }
    } catch {
        Write-Host "  ❌ Error al procesar ${size}x${size}: $_" -ForegroundColor $Red
    }
}

# Generar favicon.ico (múltiples tamaños en un archivo)
Write-Host ""
Write-Host "🎨 Generando favicon.ico..." -ForegroundColor $Yellow

try {
    magick convert "$sourceIcon" -define icon:auto-resize=16,32,48,64,256 "public\favicon.ico"
    
    if (Test-Path "public\favicon.ico") {
        $fileSize = (Get-Item "public\favicon.ico").Length
        $fileSizeKB = [math]::Round($fileSize / 1KB, 2)
        Write-Host "  ✅ favicon.ico generado ($fileSizeKB KB)" -ForegroundColor $Green
    }
} catch {
    Write-Host "  ❌ Error al generar favicon.ico: $_" -ForegroundColor $Red
}

# Generar icono Apple Touch (especial para iOS)
Write-Host ""
Write-Host "🍎 Generando Apple Touch Icon..." -ForegroundColor $Yellow

try {
    # Apple recomienda 180x180 para iPhone X y superior
    magick convert "$sourceIcon" -resize 180x180 "$outputDir\apple-touch-icon.png"
    
    if (Test-Path "$outputDir\apple-touch-icon.png") {
        $fileSize = (Get-Item "$outputDir\apple-touch-icon.png").Length
        $fileSizeKB = [math]::Round($fileSize / 1KB, 2)
        Write-Host "  ✅ apple-touch-icon.png generado ($fileSizeKB KB)" -ForegroundColor $Green
    }
} catch {
    Write-Host "  ❌ Error al generar apple-touch-icon.png: $_" -ForegroundColor $Red
}

# Resumen
Write-Host ""
Write-Host "========================================" -ForegroundColor $Yellow
Write-Host "  ✅ Proceso completado" -ForegroundColor $Green
Write-Host "========================================" -ForegroundColor $Yellow
Write-Host ""
Write-Host "Iconos generados en: $outputDir" -ForegroundColor $Green
Write-Host ""
Write-Host "Próximos pasos:" -ForegroundColor $Yellow
Write-Host "  1. Actualiza public/manifest.json con las nuevas rutas de iconos" -ForegroundColor $Yellow
Write-Host "  2. Actualiza los layouts para usar los nuevos iconos" -ForegroundColor $Yellow
Write-Host "  3. Prueba la PWA en diferentes dispositivos" -ForegroundColor $Yellow
Write-Host ""
