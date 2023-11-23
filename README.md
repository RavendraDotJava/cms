# Craft 3 Boilerplate

A base Craft install. Change the title and add additional client information here.

## Technical Overview

This project is built on Craft 4. It uses the following plugins:

* Minfiy - A small library that is used to minify blocks of code.

## Build Overview

This boilerplate project includes scaffolding for a number of build tools and frameworks intended as a jumping-off point for rapidly spinning up new projects. Base configuration files and commonly used components are included to both speed up development and provide examples of components are built.

Node Version: 15

### WebPack

WebPack is the the buildtool of choice for this project. It is used to manage the dependency tree, and is responsible for:

* Building the JavaScript bundles that are used by the front-end
* Initializing CSS processing, incuding:
  * Processing basic Sass
  * Incorporating Tailwind CSS utility classes
  * Executing Purge CSS on production builds to eliminate unused classes
  * Executing cssnano on production builds to minify CSS output

Additionally, WebPack is also used to run a local development server, leveraging BrowserSync to enable hot module reloading for more efficient development.

### TailwindCSS

TailwindCSS is a CSS framework that integrates with WebPack in order to produce a fully-customizable set of utility classes for styling front-end components and templates. It is the framework of choice for Craft&Crew builds for a number of reasons:

* It's highly configurable nature means that it can be used to establish a consistent design system
* It allows for rapid building of templates and components
* Integration with IntelliSense brings TailWind classes directly into VS Code
* By only declaring any given rule ONCE (for the most part) and leveraging PurgeCSS to remove unused classes, we keep our production CSS lean an efficient!

### AlpineJS

AlpineJS is a lightweight JavaScript framework that allows for the implementation of modern interaction through reusable, reactive components using a Vue-style syntax.




## Hosting Information

Fill in the client's hosting details here.

## Links

* [Staging](http://craft-boilerplate.previews.soshal.ca/)
* [Production](https://www.craft-boilerplate.com/)

## Todos

* Nada!

## Authors

* **Gregor Terrill (Soshal)** - *Initial development*
