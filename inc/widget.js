function select_text(objSel, objIn)
{
    txtOtp = ""; //objSel.options[objSel.selectedIndex].text;

    objSel.addEventListener('click', function()
    {
        txtOtp = this.options[objSel.selectedIndex].text;
        document.getElementById(objIn.toString()).value = txtOtp;
    });

    txtOtp = null;
    objSel_ = null;
}