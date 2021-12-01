# Contributing to ToDoList App

1/ Install the locally project
If you have not already done so, install the project on your machine via Git, following the installation instructions of the Readme file.
More details on the GitHub documentation.

2/ Make issues
-Create a new issue that you will update throughout the process.
and Check if it is not already created.  Update if necessary.

3/ Create a new branch by respecting the conventions: (in English).
            git checkout -b [prefix]/[name],
            hotfix/: for changes/bugs,
            feature/: for the addition of new features.

4/ Work on your branch

5/ Test your changes
   Run the tests to verify that they still pass after your edits

6/ Commit your git code commit -m "message".

Type =

- build: changes that affect the build system or external dependencies (npm, make...)
- here: changes concerning integration or configuration files and scripts (Travis, Ansible, BrowserStack...)
- feat: added a new feature
- fix: fixed a bug
- perf: improved performance
- refactor: change that does not bring new functionality or performance improvements
- style: change that does not bring any functional or semantic alteration (indentation, formatting, adding space, renaming a variable...)
- docs: writing or updating documentation
- test: adding or modifying tests-

7/ Push your branch git push origin my-new-feature

8/ Create Pull Request

9/ php/bin/phpunit
    Update existing tests
    Create your tests.

10/ Standards to be respected

- PSR-1 = Basic coding standard
- PSR-4 = Improvement of the PSR-0 Specification for auto loading classes (file structure directive)
- PSR-7 = HTTP message interface
- PSR-12 = Style Guide

You must meet Symfony's code standards [link contributing](https://github.com/symfony/symfony/blob/5.4/CONTRIBUTING.md)

11/ Name conventions
Use namespaces for all your classes and name them in UpperCamelCase
Variables, functions, and arguments must be named in camelCase
