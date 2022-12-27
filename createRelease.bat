mkdir release_temp
xcopy src release_temp /s

cd src_doc
mkdocs build
xcopy site ..\release_temp\admin_panel\help /s
rmdir site /s /q

cd ../doc
mkdocs build

cd ../
mkdir release
tar.exe -c -f release/woca-server.tar release_temp doc/site

rmdir doc\site /s /q
rmdir release_temp /s /q