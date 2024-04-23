# ubc_saml_auth10

For setting protected paths, in Drupal ^9.2 || ^10, PHP 8


## Protecting Private File Media
This module can be used in conjunction with other modules to provide protections for private file media types.
1.  Download [r4032login module](https://www.drupal.org/project/r4032login)
2.  Download [private file download permission module](https://www.drupal.org/project/private_files_download_permission)
3. Navigate to `/admin/people/permissions` and find the setting for `Bypass Private files download permission`. Check the "Authenticated User" box and hit Save.
4. Navigate to `/admin/config/system/r4032login/settings` and select `Allow redirect for listed pages`, add in the private file system path the site uses, appended with a `*` wildcard. For example: `/system/files/media-uploads/files/*` and hit Save.
5.  Navigate to the "Anonymous Behaviour" Tab and change the redirect path to `/saml_login` and hit Save.

This should ensure that private files are not accessible by unauthenticated users, if a private file is accessed via a direct link this will be blocked by the private file download permission module which will cause a 403, the 4032login module will cause this 403 to redirect to a CWL login. Upon successful CWL login the user will be redirected back to the original file they were attempting to access. Upon unsuccessful login the access will be denied. This provides extra protection for private files and allows for the protection of private files as a media type rather than needing to attach them to a node and protect that node.
