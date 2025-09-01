
If you need to run php-cig in the background, use the following:

PowerShell

```powershell
Start-Process "C:\php\php-cgi.exe" -ArgumentList '-b 127.0.0.1:9000 -c C:\php\php.ini'
```

Cmd

```cmd
start "" C:\php\php-cgi.exe -b 127.0.0.1:9000 -c C:\php\php.ini
```

Stop PHP

```cmd
taskkill /IM php-cgi.exe /F
```
