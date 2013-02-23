# OData API for Wordpress by People & Code Inc.

This plugin is designed to generate an OData API interface for any Wordpress powered website.

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

## Templates

You can think of templates here as the view layer in an MVC-ish way. The controllers will generate the appropriate `query_posts()` with `$args`.  

## Plugin included defaults

The templates (Views) that generate the OData payload by default are found in the templates directory.  Within this directory there are currently 3 subfolders:

1. defaults (Generates Error Views)
2. entities (Generates Entity Views i.e. an Indivdual Post)
3. entitysets (Generates Entity Set Views i.e. a Post Type, Page Type or Custom Post Type)

### Overriding default templates

Template folder structure

- odata
	- tempaltes
	- defaults
		- <FileName>.php (Example: odata.svc.php)
	- <ControllerName>
		- <ControllerMethod> (Example: index.php or show.php for the index or show method in the class)