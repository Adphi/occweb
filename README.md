# ⚠️ Deprecated ⚠️ OCCWeb terminal

### A web terminal for admins to launch Nextcloud's occ commands

![occweb](https://github.com/Adphi/OCCWeb/raw/main/appinfo/screenshot.png)


## ⚠️ Deprecated ⚠️
As nextcloudd has no native support for asynchronous operations, due to the use of php, this aplication is deprecated, and will no longer support the Nextcloud' future versions (19+). I did not find a way to implemement true support for interactive and long running occ tasks in a web terminal whitout introducing addtional dependencies (through websockets, for example), the lack of true asynchronous occ operations can lead to serious alterations of voluminous instances. 
[This issue](https://github.com/nextcloud/server/issues/16726) may give some hints on why I decided to not support this application anymore.


## Install

Place this app in **nextcloud/apps/**

## ⚠️ Warnings ⚠️

- The application is not a real interactive terminal and does not support long running tasks. 
So if your instance is pretty big, commands like `occ files:scan` will time out and fail.
- Do not use `occ maintenance:mode --on`, obvious...

## TODOs:
See [open issues](https://github.com/Adphi/occweb/issues)
