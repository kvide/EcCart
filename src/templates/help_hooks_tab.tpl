<h3>Hooks</h3>
<p>This module uses Hooks to tie in external functionality.  The following hooks are available:</p>
<ul>
    <li><code>MAMS::BeforeChangeSettings</code>
        <p>Sent after the change settings form has been submitted, but before any validation occurs.</p>
	<p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>uid</code> : int - The user id</li>
	</ul>
    </li>
    <li><code>MAMS::ChangeSettingsAfterValidate</code>
        <p>Sent after all validation is done in the change settings form, but before anything is saved to the database.</p>
	<p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>uid</code> : int - The user id</li>
	</ul>
    </li>
    <li><code>MAMS::OnCreateUser</code>
        <p>Sent after a user is created in the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>name</code> : string - The username</li>
	</ul>
    </li>
    <li><code>MAMS::OnUpdateUser</code>
        <p>Sent after a user information is edited in the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>name</code> : string - The username</li>
	</ul>
    </li>
    <li><code>MAMS::OnDeleteUser</code>
        <p>Sent before a user is removed from  the database.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The user id</li>
	   <li><code>username</code> : string - The username</li>
	</ul>
    </li>
    <li><code>MAMS::OnCreateGroup</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	   <li><code>description</code> : string - The group description</li>
	</ul>
    </li>
    <li><code>MAMS::OnUpdateGroup</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	   <li><code>description</code> : string - The group description</li>
	</ul>
    </li>
    <li><code>MAMS::OnDeleteGroup</code>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The group id</li>
	   <li><code>name</code> : string - The group name</li>
	</ul>
    </li>
    <li><code>MAMS::BeforeLogin</code>
        <p>Sent before a user is authenticated or logged in. Handlers can throw the <code>FeuLoginFailedException</code> to generate an error.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>groups</code> : string - A list of onlygroups (see the onlygroups param)</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>MAMS::AfterLoginAuth</code>
        <p>Sent after a user is authenticated, but before actually being logged in.  This hook is useful to allow other modules to do additional security checks.  Handlers can throw a <code>FeuLoginFailedException</code> to generate an error.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The id detected for this username.</li>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>groups</code> : string - A list of onlygroups (see the onlygroups param)</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>MAMS::OnLoginFailed</code>
        <p>Sent when a login attempt has failed for some reason.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>username</code> : string - The provided username.</li>
	   <li><code>msg</code> : string - The error message associated witht he failed login attempt.</li>
	</ul>
    </li>

    <li><code>MAMS::OnExpireUser</code>
        <p>Sent when a user session is expired, and the user is logged out.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The expired userid.</li>
	   <li><code>username</code> : string - The expired username.</li>
	</ul>
    </li>

    <li><code>MAMS::BeforeAnonimizeUser</code>
        <p>Sent immediately before a user is anonimized.</p>
	<p>Parameters:</p>
	<ul>
	    <li><code>$uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>MAMS::AfterAnonimizeUser</code>
        <p>Sent immediately after a user is anonimized.</p>
	<p>Parameters:</p>
	<ul>
	    <li><code>$uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>MAMS::AferVerify</code>
        <p>Sent immediately after a user account is verified.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	    <li><code>uid</code> : int - The userid to expire.</li>
	</ul>
    </li>

    <li><code>MAMS::ClearUserHistory</code>
        <p>Sent immediately before user history is cleared from the database.</li>
        <p>Parameters:</p>
	<ul>
	    <li><code>$older_than</code> : int - A unix timestamp containing the maximum time of records to keep.</li>
	</ul>
  </li>

  <li><code>MAMS::OnLogin</code>
        <p>Sent after a successful login operation.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The userid.</li>
	   <li><code>username</code> : string - The username.</li>
	   <li><code>ip</code> : string - The IP address detected.</li>
	</ul>
    </li>

    <li><code>MAMS::OnLogout</code>
        <p>Sent after a user has been logged out of the system.</p>
        <p>Parameters (as an associative array)</p>
	<ul>
	   <li><code>id</code> : int - The userid.</li>
	</ul>
    </li>
</ul>