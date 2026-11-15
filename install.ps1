$ErrorActionPreference = 'Stop'
composer create-project codeigniter4/appstarter pos-app
if ($LASTEXITCODE -ne 0) { throw 'Composer installation failed.' }
Copy-Item -Path "$PSScriptRoot/src/*" -Destination "$PSScriptRoot/pos-app" -Recurse -Force
Copy-Item "$PSScriptRoot/pos-app/env" "$PSScriptRoot/pos-app/.env"
Write-Host 'Project installed. Configure pos-app/.env using README.md, import SQL, then run php spark serve inside pos-app.'
