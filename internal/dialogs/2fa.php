<div class="modal fade modal-dialog-centered" id="iLostRecov" tabindex="-1" aria-labelledby="iLostRecovInfo" area-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="iLostRecovInfo">Congrats! Your're screwed:</h1>
            </div>
            <div class="modal-body">
            Welp, It looks like you've successfully screwed yourself over this time. To get your account back, you're gonna need to contact some higher-level staff my man.
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.history.go(-1); return false;">Bet</button>
            </div>
        </div>
    </div>
</div>

<!-- You forgor dialog -->
<div class="modal fade modal-dialog-centered" id="iForgotDlg" tabindex="-1" aria-labelledby="iForgotInfo" area-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="iForgotInfo">Aw damn, you forgor:</h1>
            </div>
            <div class="modal-body">
            Aw man, Must suck not to have 2FA on your account, Guess your authenticator just dipped bruh. Please enter one of your 3 Recovery Codes.
                <form method="POST">
                    <div class="mb-3">
                        <label for="otpCode" class="col-form-label">1 of the Recovery Codes:</label>
                        <input type="text" class="form-control" id="otpCode" name="otpCode">
                        <input type="hidden" class="form-control" name="rm" value="<?php echo("no"); ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-target="#otpRequired" data-bs-toggle="modal">Nvm</button>
            <button type="button" class="btn btn-danger" data-bs-target="#iLostRecov" data-bs-toggle="modal">Naw bruh</button>
            <button type="button" class="btn btn-primary">Bet</button>
            </div>
        </div>
    </div>
</div>

<!-- 2FA dialog -->
<div class="modal fade modal-dialog-centered" id="otpRequired" tabindex="-1" aria-labelledby="otpInfo" area-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="otpInfo">2-Factor Authentication</h1>
            </div>
            <form method="POST">
            <div class="modal-body">
            Yooo, My dude, it looks like your account has 2FA enabled. You're gonna need the special sauce to do this one:
                <div class="mb-3">
                    <label for="otpCode" class="col-form-label">OTP:</label>
                    <input type="text" class="form-control" id="otpCode" name="otpCode">

                    <input type="hidden" class="form-control" name="rm" value="<?php echo("no"); ?>">
                    <input type="hidden" class="form-control" name="om" value="<?php echo("yes"); ?>">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.history.go(-1); return false;">Nvm</button>
            <button type="button" class="btn btn-warning" data-bs-target="#iForgotDlg" data-bs-toggle="modal">I forgor</button>
            <button type="submit" class="btn btn-primary">Bet</button>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
var thething = new bootstrap.Modal(document.getElementById("otpRequired"), {});
document.onreadystatechange = function () {
    thething.show();
};
</script>