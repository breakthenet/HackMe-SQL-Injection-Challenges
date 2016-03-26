/*
MCCodes FREE
js/login.js Rev 1.1.0c
Copyright (C) 2005-2012 Dabomstew

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
function getCookieVal(offset)
{
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == -1)
        endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}
function GetCookie(name)
{
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen)
    {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
            return getCookieVal(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0)
            break;
    }
    return null;
}
function SetCookie(name, value, expires, path, domain, secure)
{
    document.cookie = name + "=" + escape(value)
            + ((expires) ? "; expires=" + expires.toGMTString() : "")
            + ((path) ? "; path=" + path : "")
            + ((domain) ? "; domain=" + domain : "")
            + ((secure) ? "; secure" : "");
}

function DeleteCookie(name, path, domain)
{
    if (GetCookie(name))
    {
        document.cookie = name + "=" + ((path) ? "; path=" + path : "")
                + ((domain) ? "; domain=" + domain : "")
                + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}
var usr;
var pw;
var sv;
function getme()
{
    usr = document.login.username;
    pw = document.login.password;
    sv = document.login.save;

    if (GetCookie('username') != null)
    {
        usr.value = GetCookie('username');
        pw.value = GetCookie('password');
    }
    if (GetCookie('save') == 'true')
    {
        sv[0].checked = true;
    }
    else
    {
        sv[1].checked = true;
    }

}
function saveme()
{
    if (usr.value.length != 0 && pw.value.length != 0)
    {
        if (sv[0].checked)
        {
            expdate = new Date();
            expdate.setTime(expdate.getTime() + 31536000000);
            SetCookie('username', usr.value, expdate);
            SetCookie('password', pw.value, expdate);
            SetCookie('save', 'true', expdate);
        }
        if (sv[1].checked)
        {
            DeleteCookie('username');
            DeleteCookie('password');
            DeleteCookie('save');
        }
    }
    else
    {
        alert('You must enter a username/password.');
        return false;
    }
}