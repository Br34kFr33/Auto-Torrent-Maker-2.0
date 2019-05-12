# Auto-Torrent-Maker-2.0
Simple script that scans a directory for files and creates .torrent file using mktorrent.  This torrent maker doesn't move the file after torrent creation.  Instead it uses a log to keep track of torrents that have been created.  Goes along great with RuTorrent.

## Requirement
* php
* mktorrent

## Setup
1. Define your user directory on line 1.  This is usually /home/YOUR-USERNAME
2. Add your announce and passkey to line 5.
3. Place this script in your user directory.
4. Create 2 directories, scan, and torrent.
5. Create a text file in user directory and name it log.txt

## How to use along with RuTorrent
1. Follow the setup steps above.
2. In rutorrent setup automove plugin. 
3. Enable AutoMove and set "Path to finished downloads" to the scan directory.
4. If there is a download you don't want a torrent created for just copy file name and paste on next line of job log.

## How to use
Place the files you want torrents to be created for in the scan directory.  Open ssh (putty etc...) type php torrent_maker.php and let the script do the rest.
