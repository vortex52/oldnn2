# oldnn
Test project "old nn" v 1.2
========================

General description:
------------
The project is a yandex maps api v2.0 on which markers are displayed in the form of a camera icon, when clicked, a photo with past views of our city is displayed.

Together with the photo, the title, description and the estimated year of shooting are displayed.

For the convenience of searching, there is a form for filtering by tags at the top of the page and a two-position slider for filtering marketers in the interval of years - just below the map

There is a custom admin panel for users to upload markers with photos

There is also a main admin panel for managing all markers and users

Backend:
------------
The server side of the project is made on the symfony 3.4 php framework - framework-standard-edition
**Additionally, the following bundles (modules) are installed:**
+ VichUploaderBundle - (work with files)
+ KnpPaginatorBundle - (pagination)
+ LiipImagineBundle - (thumbnails)
+ The features of the settings are almost standard:
+ Doctrine ORM, routing in yml configs, Doctrine annotations.

Main functionality:
------------
+ User authorization through the form.
+ User registration.
+ Arithmetic captcha on key forms.
+ Forgotten password recovery via email.
+ 3 role types (USER, ADMIN, ANONIM).
+ Dynamic loading of the first marker at page start.
+ Personal account for users - with the ability to change your password, upload your own markers and view your uploaded content.
+ Administrator's office - viewing and editing all markers, including hidden ones. View deletion and blocking of all users. Clearing the cache.
+ Sending an email to the administrator with a link for the subsequent moderation of the marker data
+ Auto-incrementing versions of styles and scripts when clearing the cache
+ Creating dynamic thumbnails for previewing the bullet list in the admin panel

FrontEnd:
------------

**Libraries:**
+ jquery-1.12.0
+ jquery-ui-1.12.1
+ bootstrap-4.3.1
+ font-awesome-4.7.0
+ poper
+ bootstrap-confirmation
+ bootstrap-tagsinput

**Yandex map functionality:**
Markers are loaded via json and added to the objectManager (which, as it were, implies stable operation with over 50,000 objects, but this is not accurate)

The backend is engaged in the formation of the source json file, creating it from 3 tables

Additionally configured on the map:
------------
+ Clustering markers
+ Custom marker icons
+ Custom cluster icons
+ Rotation of the icon depending on the rotation setting in the object properties
+ Initial loading of the first marker on page start
+ Popup output with enlarged photo when clicking on the right block
+ Auto-scaling of the map by the geometry of all markers when the map is first loaded
+ Highlighting the selected marker with a different color and centering on it when clicked
+ Filtering markers by tags via autocomplete in the search field.
+ Each marker can have several tags and you can filter them by any of the occurrences
+ Filter markers by year of the photo as a two-position slider
