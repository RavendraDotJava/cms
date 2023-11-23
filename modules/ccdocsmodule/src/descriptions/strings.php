<?php

return (object)[

  "section" => [
    "page" => "This section is used for the site's primary content pages.",
  ],

  "sectionFull" => [
    "page" => "The *Pages* section is a structure used for the site's primary content pages.",
  ],

  "type" => [
    "page" => "This entry type is the primary page entry type, which will be used for the majority of pages. It features the full module set, along with the ability to define a \"landing page\" mode (which changes the header layout).",
    "pageFeed" => "This is a custom entry type specifically to be used for feed pages.",
  ],

  "typeFull" => [
    "page" => "The *Modular Page* is an entry type intended for richer, marketing-specific pages. It allows for the inclusion of a number of different modules, making it a highly flexible option that can be used to build out key marketing pages.",
  ],

  "assetFull" => [
    "images" => "The *Images* volume is likely to be the most used volume on the site. It is inteded to house all the imagery and photography to be used in headers, along with most blocks and modules.\n\nAssets in this volume contain the following fields:",

    "videos" => "The *Videos* volume is used for adding video assets to the site. The concept here is to use a custom cover image for the video, and then add the video ID directly to the asset (along with a transcript for accessibility).\n\nThere are several reasons for this approach:\n\n - Using a custom cover image provides greater control over the display of the video block as opposed to a standard video embed.\n\n - Similarly, by using the cover image, we also avoid loading all the YouTube assets associated with the video until the user actually requests for it to be played. This technique is commonly known as using a façade.\n\n - By setting up a custom volume, wecan easily configure modules that allow the use of a video <em>or</em> and image asset.\n\n - It also allows us to define the video once and then use it within multiple entries without having to enter duplicate content.\n\nAssets in this volume contain the following fields:",
    
    "clients" => "The *Clients* volume is used specifically for client logos. These logos can be used in several different places across the site. Given the often differing sizing of logos, assets in this volume have a the Logo Size field, which determines how the logo image will be cropped and displayed.\n\n<b>Note:</b> Please be sure to give the client asset the approrpiate client name, OR to place the client name in the Alt Text field. It is important for accessibility that logos provide alternative text with the proper name.\n\nAssets in this volume contain the following fields:"
  ],


  "globalFull" => [
    "header" => "The *Header* global set is used to define content and elements that appear in the global header.",
    "footer" => "The *Footer* global set is used to define content and elements that appear in the global footer.",
    "notFound" => "The *404* global set allows us to define content that appears on the 404 page, which is shown when a user attempts to reach a page that does not exist. Because the no entry is present, this content needs to be defined outside of any entries.",
  ],

];