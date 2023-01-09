# WOCA-Server
An app content server written in PHP for rowing and canoe clubs.

The project is under work and at the moment not finished:

- Many of the device drivers are not complete or tested to work properly.
- Inputs are not validated
- The API may change

## Features

App Interface

Admin-Panel

## Versioning scheme
Version number: M.SS.RR (e.g.: 0.10.312)

0 = Main version number
	Not backward compatible changes
	Bigger package of changes
    New main features
A = Sub version number
	Implementing of a new feature/module
B = Revision number
	Corrections at the modules (bug fixing)


## Folder structure

| folder | description |
| --- | --- |
| doc | documentation of the server |
| src | php source files |
| src_doc | help pages inside admin-panel |
| release_temp | temporary folder |
| release | release files of the project |

## Documentation

Can be found in the folder "/doc" and "/src_doc". 

Generated with MKDocs (Python). It can be installed using PIP.

```
pip install mkdocs
pip install mkdocs-material
```

To build the documentation the following commands (inside the doc folder) can be used:
```
mkdocs serve
```
## Build

Release file can be build using the 'createRelease.bat' script. It builds the documentation and creates an tar files in the release folder, containing all required project files.

## License

The project is licensed under the **GPL V3** open-source license.
