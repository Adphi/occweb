# OCCWeb terminal

### A web terminal for admins to launch Nextcloud's occ commands

![occweb](https://git.adphi.net/Adphi/OCCWeb/raw/master/appinfo/screenshot.png)


## Install

Place this app in **nextcloud/apps/**

## ⚠️ Warnings ⚠️

- The application is not a real interactive terminal and does not support long running tasks. 
So if your instance is pretty big, commands like `occ files:scan` will time out and fail.
- Do not use `occ maintenance:mode -on`, obvious...

## TODOs:
See [open issues](https://git.adphi.net/Adphi/OCCWeb/issues)
