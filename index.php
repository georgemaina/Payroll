<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../../extjs/resources/css/ext-all.css">
        <script type="text/javascript" src="../../Extjs/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="../../Extjs/ext-all-debug.js"></script>

        <script type="text/javascript" >
            Ext.BLANK_IMAGE_URL = "../../Extjs/resources/images/default/s.gif";
            Ext.onReady(function() {

                var loginHandle = function() {
                    var user = document.getElementById('login-user').value;
                    var pass = document.getElementById('login-pwd').value;

                    if (user === '' || pass === '') {
                        Ext.MessageBox.alert('Warning', 'Username and Password cannot be empty');
                    } else {
                        Ext.Ajax.request(
                                {
                                    // waitMsg: 'Saving changes...',
                                    url: 'data/getDataFunctions.php?task=doLogin', //ph nffffffffffffffffffffffffffl.g.f.glp
                                    params: {
                                        user: user,
                                        pass: pass
                                    },
                                    success: function(response, options) {
                                        var strResp=Ext.decode(response.responseText);
                                        if(strResp.Error==='0'){
                                            //Ext.MessageBox.alert('Success', 'Successfuly Logged In as '+strResp.UserName);
                                            document.location.href = 'app.php';
                                        }else if(strResp.Error==='1'){
                                            Ext.MessageBox.confirm("Login","It seems you are already Logged in,\n would like to continue with your session?",function(btn){
                                                    if(btn=='yes'){
                                                        //document.location.href = 'app.php?user='+user;
                                                        document.location.href = 'app.php';
                                                    }else{
                                                        logout(user);
                                                    }
                                                });
                                        }else{
                                            Ext.MessageBox.alert('Warning', 'Invalid login Info, Check the username and password...');
                                        }

                                    },
                                    failure: function(response, options) {
                                        var strErr=Ext.decode(response.responseText);
                                        Ext.MessageBox.alert('Warning', 'Invalid login Info, Check the username and password...'+strErr);
                                        //ds.rejectChanges();//undo any changes
                                    }
                                }
                        );
                    }
                };
                
                var logout=function(user){
                    Ext.Ajax.request(
                                {
                                    // waitMsg: 'Saving changes...',
                                    url: 'data/getDataFunctions.php?task=doLogout', //ph nffffffffffffffffffffffffffl.g.f.glp
                                    params: {
                                        user: user
                                    },
                                    success: function(response, options) {
                                         Ext.MessageBox.alert('Success', 'Successfuly Logged out user '+strResp.UserName);
                                    },
                                    failure: function(response, options) {
                                        var strErr=Ext.decode(response.responseText);
                                        Ext.MessageBox.alert('Warning', 'A Problem occured during Logout process, please try again'+strErr);
                                        //ds.rejectChanges();//undo any changes
                                    }
                                }
                        );
                };

                var loginForm = new Ext.FormPanel({
                    // xtype: 'form',
                    id: 'login-form',
                    bodyStyle: 'padding:15px;background:transparent',
                    border: true,
                    width: 350,
                    //                    url:'login.php',
                    items: [{
                            xtype: 'box',
                            autoEl: {tag: 'div',
                                html: "<div class='app-msg'><img src='images/care_logo_mysql.gif' class='app-img' />  <b>Payroll Login</b></div>"}
                        },
                        {xtype: 'textfield',
                            id: 'login-user',
                            fieldLabel: 'Username',
                            allowBlank: false,
                            msgTarget: 'side'
                        },
                        {
                            xtype: 'textfield',
                            id: 'login-pwd',
                            fieldLabel: 'Password',
                            inputType: 'password',
                            allowBlank: false,
                            url: 'login.php',
                            msgTarget: 'side',
                            minLength: 6,
                            minLengthText: 'Password must be atleast six characters',
                            maxLength: 10,
                            validationEvent: false,
                            listeners: {
                                specialkey: function(f, e) {
                                    if (e.getKey() == e.ENTER) {
                                        //                                        alert("about to submit");
                                        loginHandle();
                                    }
                                }

                            }
                        }
                    ],
                    buttons: [{
                            text: 'Login',
                            handler: loginHandle
                        },
                        {
                            text: 'Cancel',
                            handler: function() {
                                win.hide();
                            }
                        }]
                })


                var border = new Ext.Panel({
                    title: 'Login Form',
                    layout: 'border',
                    items: [{
                            region: 'north',
                            margins: '0 0 0 0',
                            cmargins: '0 0 0 0',
                            height: 220,
                            minSize: 100,
                            maxSize: 300,
                            border: false
                        }, {
                            region: 'west',
                            margins: '0 0 0 0',
                            cmargins: '0 0 0 0',
                            width: 500,
                            minSize: 100,
                            maxSize: 300,
                            border: false
                        }, {
                            region: 'center',
                            margins: '0 0 0 0',
                            top: 150,
                            border: false,
                            items: [loginForm]
                        }]
                });

                var viewport = new Ext.Viewport({
                    // Position items within this container using
                    //  CSS-style absolute positioning.
                    layout: 'fit',
                    items: [border]
                });

                viewport.render(document.body);

            });

        </script>
    </head>
    <body>

    </body>
</html>
