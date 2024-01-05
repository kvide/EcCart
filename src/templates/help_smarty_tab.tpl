<h3>Smarty Plugins:</h3>
<h4>&#123;mams_user_options}</h4>
<p>This function plugin provides a convenient method to generate options for a select element with users from the MAMS module.  This is useful in admin interfaces.</p>
<h5>Usage:</h5>
<pre><code>&#123;mams_user_options [group=string] [notdisabled=bool] [notexpired=bool] [use_userids=bool] [selected = mixed]}</code></pre>
<h5>Parameters:</h5>
<ul>
    <li><code>group=string</code> - Display only users that are members of the named group.</li>
    <li><code>notexpired=bool</code> - Display only users that are not expired.</li>
    <li><code>notdisabled=bool</code> - Display only users that arer not disabled.</li>
    <li><code>use_userids=bool</code> - (default false) The values for each option will be the userid, not the username.</li>
    <li><code>selected = mixed</code> - The value of the option to select.  If use_userids is enabled, this should be an integer uid.  Otherwise this should be a username string.</li>
</ul>

<hr>

<h4>&#123;mams_protect}</h4>
<p>The <strong>mams_protect</strong> block plugin provides a convenient method to hide some content from users on what is normally a public page.</p>

<div class="warning"><p><strong style="color: red;">Warning:</strong></p>
  <p> This plugin cannot be considered 100% secure, and should not at any time be used in the page template to protect the default &#123;content} tag.  There are ways to access the default content property of a page, or to call a module action without processing the page template.  If you need to protect the content and ensure that no unauthorized users access the page, use the protected page content type provided by this module.</p>
</div>
<h5>Usage:</h5>
<pre><code>&#123;mams_protect groups="group1,group2,grop3"}
  &lt;p&gt;Smarty content that should only be visible to members of those groups.&lt;/p&gt;
&#123;/mams_protect}</code></pre>
<div class="information">
  <p><strong>Note:</strong> The user must be a member of at least one of the specified groups.  The group names are case sensitive.</p>
</div>
<hr>

<h4>The mams_smarty class</h4>
<p>The <strong>mams_smarty</strong> class provides some functions to interact with the database and pull and test for user information.</p>
<p>Some interaction with the MAMS module database is possible with smarty and the mams_smarty class.</p>

<h5>Functions:</h5>
<ul>
<li><strong><code>&#123;mams_smarty::get_current_userid()}</code></strong>
<p>This function returns the integer user id if the currently logged in user (if any).</p>
<p>Example:</p>
<pre><code>&#123;$uid = mams_smarty::get_current_userid()}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_current_username()}</code></strong>
<p>This function returns the user name if the currently logged in user (if any).</p>
<p>Example:</p>
<pre><code>&#123;$username = mams_smarty::get_current_username()}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_userid($username)}</code></strong>
<p>This function can be used to return the integer user id given a username.</p>
<p>Example:</p>
<pre><code>&#123;$uid = mams_smarty::get_userid($username)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_username([$uid])}</code></strong>
<p>This function can be used to return the string username given an integer uid.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>&#123;mams_smarty::get_username($the_uid)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_email([$uid])}</code></strong>
<p>This function can be used to return an email adderess associated with the given integer uid.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>&#123;mams_smarty::get_email($the_uid)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_userinfo([$uid])}</code></strong>
<p>This function can be used to return the user information for a single user.  If no uid is specified, the current logged in uid is assumed.</p>
<p>Example:</p>
<pre><code>&#123;$uinfo = mams_smarty::get_userinfo($something.userid)}<br />&#123;$uinfo|@print_r}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_users_by_groupname($groupname[,$for_list])}</code></strong>
<p>This function can be used to extract an array of usernames and userids for all users that belong to the specified group.</p>
<p>The groupname parameter must be a single string groupname.</p>
<p>The for_list parameter is a boolean that indicates that the output should be suitable for use in a select list.</p>
<p>Example:</p>
<pre><code>&#123;$mymembers = mams_smarty::get_users_by_groupname('members')}<br />&#123;$mymembers|@print_r}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_group_memberlist($gid)}</code></strong>
  <p>This function returns an array of uid and usernames for all users that are members of the specified group (by group id).</p>
  <p>Example:</p>
  <pre><code>&#123;html_options options = mams_smarty::get_group_memberlist($gid) selected=$uid}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_user_expiry([$uid])}</code></strong>
<p>This function returns the unix timestamp that the specified uid account expires.  The function will return false if the uid cannot be found or some other error occurred.</p>
<p>Example:</p>
<pre><code>&#123;$expiry = mams_smarty::get_user_expiry(25)}<br />&#123;$expiry|cms_date_format}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::user_expired($uid)}</code></strong>
<p>This function returns a boolean indicating wether the specified user account has expired.  The method will also return false if the uid cannot be found or some other error occurred.</p>
<p>Example:</p>
<pre><code>&#123;$expired = mams_smarty::user_expired(25)}<br />&#123;if $expired}UID 25 can no longer login to the system&#123;/if}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_user_properties($uid)}</code></strong>
<p>This function can be used to extract a list of properties for the specified user.  If the uid is not specified the current logged in uid is used.</p>
<p>Example:</p>
<pre><code>&#123;$userprops = mams_smarty::get_user_properties(5)}<br />&#123;$userprops|@print_r}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_user_property($property,[$uid])}</code></strong>
  <p>This function returns the value of a single property for the specified uid.  If the uid parameter is not specified, the current logged in uid is used.</p>
  <p>Example:</p>
  <pre><code>&#123;mams_smarty::get_user_property('fullname',5)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_dropdown_text($propname,$propvalue)}</code></strong>
  <p>This function returns the text specified for a particular option value for a specified dropdown property.</p>
  <p>Example:</p>
  <pre><code>&#123;mams_smarty::get_dropdown_text('age_range',$onepropvalue)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_multiselect_text($propname,$propvalue)}</code></strong>
  <p>This function returns an array of option texts corresponding to a comma separated list of option values.</p>
  <p>Example:</p>
  <pre><code>&#123;$favorite_foods = mams_smarty::get_multiselect_text('favorite_foods',$onepropvalue)}<br />&#123;$favorite_foods|@print_r}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_group_list()}</code></strong>
  <p>This function returns an array of MAMS groups that is suitable for use in a dropdown.</p>
  <p>Example:</p>
<pre><code>&lt;select id="group"&gt;&#123;html_options options = mams_smarty::get_group_list()}&lt;/select&gt;</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::get_user_groups([$uid])}</code></strong>
  <p>This function returns an array of MAMS groups that this user belongs to (if any).  The output is an array suitable for use in a select list (the key is the groupid, value is the group name).</p>
  <p>Example:</p>
<pre><code>&#123;$mygroups = mams_smarty::get_user_groups()}
&#123;$mygroups|@print_r}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::preload_users($uid_list[,$deep = false])}</code></strong>
  <p>This function will preload information for the specified users.  It does not return any output.</p>
  <p>Example:</p>
<pre><code>&#123;$list = [ 5, 10, 11, 13, 18 ]}
&#123;mams_smarty::preload_users($list)}</code></pre>
</li>

<li><strong><code>&#123;mams_smarty::is_user_memberof($groups[,$uid])}</code></strong>
  <p>This function returns a boolean if the user is a member of one the specified groups.</p>
  <p>The groups parameter can be a comma delimited string of group names, or an array of group names.</p>
  <p>If the uid parameter is not specified, the currently logged in userid is used.</p>
  <p>Example:</p>
<pre><code>&#123;if mams_smarty::is_user_memberof('Staff,Managers')}Hello Customer&#123;/if}</code></pre>
</ul>