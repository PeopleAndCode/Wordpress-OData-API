# OData API for Wordpress by People & Code Inc.

This plugin is currently designed to generate a Read-only OData API interface for any Wordpress powered website.

The plugin tries to:

1. Follow OData terminology for its parameters.
2. Follow a pseudo MVC pattern and routing for endpoints
3. Allow an easy way to override default templates included with the plugin should the Protocol change or require customizations
4. Allows Wordpress methods and functions used in "The Loop" to be used.

## Endpoints

````
http://<blogurl>/OData/OData.svc/ => index.php?odata=OData.svc
http://<blogurl>/OData/OData.svc/<entitySet>/ => index.php?odata=OData.svc&entitySet=<entitySet>
http://<blogurl>/OData/OData.svc/<entitySet>(<entityID>)/ => index.php?odata=OData.svc&entitySet=<entitySet>&entityID=<entityID>
````
**NOTE:**

`<entitySets>` *SHOULD* take their plural forms.  Meaning the default Wordpress `post_type` is `post` BUT the `<entitySet>` should be written as `Posts` or `posts` *NOT* `Post` or `post`.  Same goes for `post_type` of `Page`.

**Why?**

It's to follow the idea of collections or `entitySets` as they represent multiple `entries`.


## Templates

You can think of templates here as the view layer in an MVC-ish way. The controllers will generate the appropriate `query_posts()` with `$args`.  It hasn't been implemented yet but the templates will in the future reflect the Methods name.  Therefore if the *Entities Controller* (`\controllers\entities_controller.php`) has a method `show()` (which it does), it should have a corresponding template/view file named `show.php` in the `\templates\entities\` folder.

## Plugin included defaults

The templates (Views) that generate the OData payload by default are found in the templates directory.  Within this directory there are currently 3 subfolders:

1. defaults (Generates Error Views)
2. entities (Generates Entity Views i.e. an Indivdual Post)
3. entitysets (Generates Entity Set Views i.e. a Post Type, Page Type or Custom Post Type)

### Overriding default templates
You can override the default templates included with the plugin by createing your own within a Wordpress theme.  Just add the following folders and files:

- odata
	- tempaltes
		- defaults
			- `odata.svc.php` (replaces `http://<blogurl>/OData/OData.svc/`)
			- `odata_error_no_data_found.php` (replaces the default error page)
		- entitysets
			- `show.php` (replaces `http://<blogurl>/OData/OData.svc/<entitySet>/`)
		- entities
			- `show.php` (replaces `http://<blogurl>/OData/OData.svc/<entitySet>(entityID)/`)
