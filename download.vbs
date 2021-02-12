Dim WinScriptHost
Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\AppServ\www\impresiones\download.bat" & Chr(34), 0
Set WinScriptHost = Nothing