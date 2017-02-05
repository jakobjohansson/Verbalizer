<?php
$root = "../../";
require($root.'lib/config.php');

if (!auth()) {
    header("Location: login.php");
}
?>
<h1>Account</h1>
<form action"#">
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Trivial <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Age</label>
                    <input type="text" />
                    <label>City</label>
                    <input type="text" />
                    <label>Website</label>
                    <input type="email" />
                    <label>Optionally write a short introduction</label>
                    <textarea></textarea>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Visual <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Enable pagination <input type="checkbox" checked /></label>
                    <label>Posts per page</label>
                    <input type="number" />
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Security <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Change your username</label>
                    <input type="text" />
                    <label>Change your password</label>
                    <input type="password" />
                    <label>Repeat password</label>
                    <input type="password" />
                    <label>Deactivate blog <input type="checkbox" /></label>
                    <small>Will redirect visitors to the "deactivate.php" template.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <input type="submit" value="Save settings" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <div id="response"></div>
        </div>
    </div>
</form>
