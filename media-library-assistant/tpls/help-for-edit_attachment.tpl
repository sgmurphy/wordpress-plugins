<!-- loaded in class-mla-edit-media.php function mla_edit_add_help_tab for the Media/Edit Media submenu screen -->
<!-- invoked as /wp-admin/post.php?post=3446&action=edit&mla_source=edit (for example) -->
<!-- template="mla-overview" -->
<!-- title="MLA Enhancements" order="10" -->
<p>Media Library Assistant adds several enhancements to the Edit Media screen:</p>
<ul>
<li>
Displays Last Modified date and time
</li>
<li>
Supports mapping of Custom Field and IPTC/EXIF/WP metadata for this attachment
</li>
<li>
Supports Custom fields, which <code>[mla_gallery]</code> can use for query and display
</li>
<li>
Supports Parent Info and Menu Order
</li>
<li>
Displays Image Metadata
</li>
<li>
Displays IPTC, EXIF, XMP, ID3, PDF and/or MSO metadata embedded in the item's file
</li>
<li>
Displays where-used information; Featured in, Inserted in, Gallery in and MLA Gallery in
</li>
</ul>
<p>Remember to click the &#8220;Update&#8221; button to save your work.</p>
<!-- template="mla-taxonomies" -->
<!-- title="Taxonomies" order="20" -->
<p>If there are custom taxonomies, such as &#8220;Attachment Categories&#8221; or &#8220;Attachment Tags&#8221;, registered for attachments they will appear in the right-hand column on this screen. You can add or remove terms from any of the taxonomies displayed. Changes will not be saved until you click the &#8220;Update&#8221; button for the attachment.</p>
<!-- template="mla-parent-info" -->
<!-- title="Parent Info" order="30" -->
<p>The &#8220;Parent Info&#8221; field displays the Post ID, type and title of the post or page to which the item is attached. It will display &#8220;0 (unattached)&#8221; if there is no parent post or page.</p>
<p>You can change the post or page to which the item is attached by changing the Post ID value and clicking the &#8220;Update&#8221; button. Changing the Post ID value to zero (0) will &#8220;unattach&#8221; the item.</p>
<!-- template="mla-file-metadata" -->
<!-- title="Attachment File Metadata" order="40" -->
<p>The &#8220;Attachment File Metadata&#8221; field displays the IPTC, EXIF, XMP, ID3, PDF and/or MSO metadata embedded in the item's file. The key to the left of the "=>" separator shows the syntax you can use to access the value as a substitution parameter.</p>
<p><strong>Compound names</strong> are used to access elements within arrays, e.g., <code>xmp:dc.description</code> is used to specify the description element in the XMP "dc" namespace. You can also use a "*" placeholder to denote "all elements at this level" and return an array of lower-level elements. For example, you can code <code>xmp:dc.subject.*</code> to return an array of keywords from the subject element of the XMP "dc" namespace.
</p>
<p>
Because the memory and processing required to populate this meta box can be significant you can disable this meta box with an option in the "Media/Edit Media Enhancements" section of the Settings/Media Library Assistant General tab.
</p>
<!-- template="mla-mapping-actions" -->
<!-- title="Metadata Mapping" order="50" -->
<p>The &#8220;Map Custom Field Metadata&#8221; and &#8220;Map IPTC/EXIF/WP Metadata&#8221; links let you create or update attachment values by applying the rules you define on the Media Library Assistant Settings page. The links are located in the &#8220;Save&#8221; meta box in the upper-right part of the screen, just below the Last Modified date and time.</p>
<p>When you click on one of the two links, all of the mapping rules for that type of metadata will be applied to the attachment you are editing. The updates are immediate; you do not need to click the &#8220;Update&#8221; button to make them permanent.</p>
