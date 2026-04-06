$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
Set-Location $root

function Ensure-Process {
    param(
        [string]$Name,
        [scriptblock]$Exists,
        [scriptblock]$Start
    )

    if (-not (& $Exists)) {
        & $Start
        Start-Sleep -Seconds 2
    }
}

# MySQL (XAMPP)
Ensure-Process -Name 'MySQL' -Exists {
    (Test-NetConnection -ComputerName 127.0.0.1 -Port 3306 -WarningAction SilentlyContinue).TcpTestSucceeded
} -Start {
    Start-Process -FilePath 'C:\xampp\mysql\bin\mysqld.exe' -ArgumentList '--datadir=C:\xampp\mysql\data','--port=3306' -WindowStyle Hidden
}

# Redis local binary
if (-not (Test-Path 'tools\redis\bin\redis-server.exe')) {
    New-Item -ItemType Directory -Force tools\redis | Out-Null
    Invoke-WebRequest -Uri 'https://github.com/tporadowski/redis/releases/download/v5.0.14.1/Redis-x64-5.0.14.1.zip' -OutFile 'tools\redis\redis.zip'
    Expand-Archive -LiteralPath 'tools\redis\redis.zip' -DestinationPath 'tools\redis\bin' -Force
}

Ensure-Process -Name 'Redis' -Exists {
    (Test-NetConnection -ComputerName 127.0.0.1 -Port 6379 -WarningAction SilentlyContinue).TcpTestSucceeded
} -Start {
    Start-Process -FilePath (Resolve-Path 'tools\redis\bin\redis-server.exe') -ArgumentList (Resolve-Path 'tools\redis\bin\redis.windows.conf') -WindowStyle Hidden
}

# Node socket server
Ensure-Process -Name 'Socket' -Exists {
    (Test-NetConnection -ComputerName 127.0.0.1 -Port 3001 -WarningAction SilentlyContinue).TcpTestSucceeded
} -Start {
    if (-not (Test-Path 'node-server\.env')) {
        Copy-Item 'node-server\.env.example' 'node-server\.env' -Force
    }
    Start-Process -FilePath 'node' -ArgumentList 'server.js' -WorkingDirectory "$root\node-server" -WindowStyle Hidden
}

# Laravel serve
Ensure-Process -Name 'Laravel' -Exists {
    (Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -WarningAction SilentlyContinue).TcpTestSucceeded
} -Start {
    Start-Process -FilePath 'php' -ArgumentList 'artisan','serve','--host=127.0.0.1','--port=8000' -WorkingDirectory $root -WindowStyle Hidden
}

# Vite dev server
Ensure-Process -Name 'Vite' -Exists {
    (Test-NetConnection -ComputerName 127.0.0.1 -Port 5173 -WarningAction SilentlyContinue).TcpTestSucceeded
} -Start {
    Start-Process -FilePath 'npm.cmd' -ArgumentList 'run','dev','--','--host','127.0.0.1','--port','5173' -WorkingDirectory $root -WindowStyle Hidden
}

php artisan migrate --force | Out-Null

Write-Host 'Keyboard race system is up:'
Write-Host 'Laravel: http://127.0.0.1:8000/keyboard-race'
Write-Host 'Socket health: http://127.0.0.1:3001/health'
Write-Host 'Vite: http://127.0.0.1:5173'
