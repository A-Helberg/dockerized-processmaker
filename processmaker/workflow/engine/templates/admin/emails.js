Ext.onReady(function(){

    var emailUrlValidationText = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))|((([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))$/i;
    Ext.apply(Ext.form.VTypes, {
        emailUrlValidation: function(val, field) {
            return emailUrlValidationText.test(val);
        }
    });

  var box = new Ext.form.Checkbox({
    boxLabel: _('ID_ENABLE_EMAIL_NOTIFICATION'),//'Enable Email Notifications',
    name: 'EnableEmailNotifications',
    id: 'EnableEmailNotifications',
    checked:false,
    disabled : true,
    listeners: {
      check: function(EnableEmailNotifications, checked) {
        if(checked) {
          combo.setVisible(true);
          Ext.getCmp('Test').setDisabled(false);
          Ext.getCmp('SaveChanges').disable();
          combo.getEl().up('.x-form-item').setDisplayed(true); // show label

          if (Ext.getCmp('EmailEngine').getValue()== 'MAIL') {
            Ext.getCmp('Server').setVisible(false);
            Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(false); // hide label
            Ext.getCmp('Port').setVisible(false);
            Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('RequireAuthentication').setVisible(false);
            Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('AccountFrom').setVisible(false);
            Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('Password').setVisible(false);
            Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('UseSecureConnection').setVisible(false);
            Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp("fromMail").setVisible(true);
            Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(true);
          } else {
            Ext.getCmp('Server').setVisible(true);
            Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(true); // hide label
            Ext.getCmp('Port').setVisible(true);
            Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(true);
            Ext.getCmp('RequireAuthentication').setVisible(true);
            Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(true);
            Ext.getCmp('AccountFrom').setVisible(true);
            Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(true);
            Ext.getCmp("fromMail").setVisible(true);
            Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(true);

            if (Ext.getCmp('RequireAuthentication').getValue() === true)
            {
              Ext.getCmp('Password').setVisible(true);
              Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(true);
              // Ext.getCmp('AccountFrom').allowBlank = false;
            } else {
              Ext.getCmp('Password').setVisible(false);
              Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
              // Ext.getCmp('AccountFrom').allowBlank = true;
            }

            if(!Ext.getCmp('UseSecureConnection').getValue()) {
              Ext.getCmp('UseSecureConnection').setValue('No');
            }

            Ext.getCmp('UseSecureConnection').setVisible(true);
            Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(true);
          }

          Ext.getCmp('SendaTestMail').setVisible(true);
          Ext.getCmp('SendaTestMail').getEl().up('.x-form-item').setDisplayed(true);

          Ext.getCmp('eFromName').setVisible(true);
          Ext.getCmp('eFromName').getEl().up('.x-form-item').setDisplayed(true);

          if(Ext.getCmp('SendaTestMail').checked) {
            Ext.getCmp('eMailto').setVisible(true);
            Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(true);
          }
          else {
            Ext.getCmp('eMailto').setVisible(false);
            Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('eMailto').setValue('');
          }

        }
        else {
          combo.setVisible(false);
          combo.getEl().up('.x-form-item').setDisplayed(false); // hide label
          Ext.getCmp('Server').setVisible(false);
          Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(false); // hide label
          Ext.getCmp('Port').setVisible(false);
          Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('RequireAuthentication').setVisible(false);
          Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('AccountFrom').setVisible(false);
          Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('Password').setVisible(false);
          Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('SendaTestMail').setVisible(false);
          Ext.getCmp('SendaTestMail').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('eFromName').setVisible(false);
          Ext.getCmp('eFromName').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp("fromMail").setVisible(false);
          Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(false);

          if (Ext.getCmp('SendaTestMail').getValue().checked) {
            Ext.getCmp('eMailto').setVisible(true);
            Ext.getCmp('eMailto').setVisible(true);
            Ext.getCmp('eMailto').setValue('');
          }
          else {
            Ext.getCmp('eMailto').setVisible(false);
            Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('eMailto').setValue('');
          }

          Ext.getCmp('UseSecureConnection').setVisible(false);
          Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(false);

          Ext.getCmp('SaveChanges').enable();
          Ext.getCmp('Test').setDisabled(true);
        }
      }
    }
  });

  var EmailEngine  = new Ext.data.SimpleStore({
    fields: ['id', 'EmailEngine'],
    data : [
      ['PHPMAILER','SMTP (PHPMailer)'],
      ['MAIL','Mail (PHP)']
    ]
  });

  var combo = new Ext.form.ComboBox({
    id:'EmailEngine',
    name:'EmailEngine',
    xtype: 'combo',
    fieldLabel: _('EMAIL_ENGINE'),//'Email Engine',
    blankText: '',
    valueField: 'id',
    lazyRender: true,
    allowBlank: false,
    selectOnFocus: true,
    forceSelection: true,
    store:EmailEngine,
    displayField:'EmailEngine',
    mode: 'local',
    triggerAction: 'all',
    value: 'PHPMAILER',
    disabled : true,
    listeners: {
      select: function(combo, value) {
        if (Ext.getCmp('EmailEngine').getValue()== 'MAIL') {
          Ext.getCmp('Server').setVisible(false);
          Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(false); // hide label
          Ext.getCmp('Port').setVisible(false);
          Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('RequireAuthentication').setVisible(false);
          Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('AccountFrom').setVisible(false);
          Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('Password').setVisible(false);
          Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
          Ext.getCmp('UseSecureConnection').setVisible(false);
          Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(false);

          //Ext.getCmp("fromMail").setVisible(true);
          //Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(true);
        } else {
          Ext.getCmp('Server').setVisible(true);
          Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(true); // hide label
          Ext.getCmp('Port').setVisible(true);
          Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(true);
          Ext.getCmp('RequireAuthentication').setVisible(true);
          Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(true);
          Ext.getCmp('AccountFrom').setVisible(true);
          Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(true);

          //Ext.getCmp("fromMail").setVisible(true);
          //Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(true);

          if (Ext.getCmp('RequireAuthentication').getValue() === true)
          {
            Ext.getCmp('Password').setVisible(true);
            Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(true);
            // Ext.getCmp('AccountFrom').allowBlank = false;
          } else {
            Ext.getCmp('Password').setVisible(false);
            Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
            // Ext.getCmp('AccountFrom').allowBlank = true;
          }

          if(!Ext.getCmp('UseSecureConnection').getValue()) {
            Ext.getCmp('UseSecureConnection').setValue('No');
          }

          Ext.getCmp('UseSecureConnection').setVisible(true);
          Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(true);
        }
        Ext.getCmp('SaveChanges').disable();
      }
    }
  });
  var tb = new Ext.Toolbar({
      style : 'background: #EEEEEE;',
      items: [{
        xtype:'button',
        id:'UnEdit',
        iconCls: 'button_menu_ext',
        icon: '/images/unlocked.png',
        handler: UnEditMethod
      },
      {
        xtype:'button',
        id:'Edit',
        iconCls: 'button_menu_ext',
        icon: '/images/locked.png',
        handler: EditMethod
      },'&nbsp;',
      {
      xtype:'label',
      text:_('ID_CLICK_LOCK'),
      id:'label'
      },
      {
      xtype:'label',
      text:_('ID_CLICK_UNLOCK'),
      id:'labelUn'
      },
      '->',
      {
        text : _('ID_TEST'),
        width: 55,
        id:'Test',
        handler: testMethod
      },'&nbsp; &nbsp;',
      {
        text : _('ID_SAVE_CHANGES'),
        id:'SaveChanges',
        width: 85,
        disabled : true,
        handler: saveMethod
      }
    ]
  });
  var EMailFields = new Ext.form.FieldSet({
    title: _('ID_CONFIGURATION'),
    items : [
      box,
      combo,
      {
        xtype: 'textfield',
        hideLabel : false,
        fieldLabel: _('ID_SERVER'),//'Server',
        id:'Server',
        //blankText: 'Server',
        width: 200,
        allowBlank: false,
        disabled : true,
        listeners : {
          'change': {
            fn:function() {
              Ext.getCmp('PasswordHide').setValue('');
              Ext.getCmp('Password').setValue('');
            }
          }
        }
      },
      {
        xtype: 'numberfield',
        fieldLabel: _('PORT_DEFAULT'),//'Port (default 25)',
        id:'Port',
        name:'Port',
        emptyText : null,
        width: 40,
        maxLength: 3,
        disabled : true,
        allowBlank: false
      },
      {
        xtype: 'checkbox',
        boxLabel: _('REQUIRE_AUTHENTICATION'),//'Require authentication',
        id:'RequireAuthentication',
        name:'RequireAuthentication',
        validateMessage: _('ID_REALLY_SHOULD'),
        validateField: true,
        disabled : true,
        handler: function() {
          if (this.checked) {
            Ext.getCmp('Password').setVisible(true);
            Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(true);
          } else {
            Ext.getCmp('Password').setVisible(false);
            Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
            Ext.getCmp('Password').setValue('');
          }
        }
      },
      {
        xtype: 'textfield',
        fieldLabel: _("ID_USER_NAME"),  //'Account From',
        id:'AccountFrom',
        name:'AccountFrom',
        vtype:'emailUrlValidation',
        width: 200,
        disabled: true,
        allowBlank: false,
        enableKeyEvents: true,
        listeners: {
            keydown: function (txt, e) {
                switch (e.getKey()) {
                    case 8:  //Delete
                    case 46: //Supr
                        if (Ext.getCmp("AccountFrom").getValue() == "") {
                            Ext.getCmp("Password").setValue("");
                        }
                        break;
                }
            },
            keyup: function (txt, e) {
                var strValue = Ext.getCmp("AccountFrom").getValue();
                var sw = 0;

                switch (e.getKey()) {
                    case 8:  //Delete
                    case 46: //Supr
                        if (strValue == "") {
                            sw = 1;
                        }
                        break;
                    default:
                        if (strValue.length <= 1) {
                            sw = 1;
                        }
                        break;
                }

                if (sw == 1) {
                    Ext.getCmp("Password").setValue("");
                }
            }
        }
      },
      {
        xtype: 'textfield',
        fieldLabel: _('ID_PASSWORD'),//'PasswordHidden',
        id:'PasswordHide',
        name:'PasswordHide',
        inputType: 'PasswordHide',
        width: 200,
        hidden: true,
        hideLabel: true,
        disabled : true,
        allowBlank: true
      },
      {
        xtype: 'textfield',
        fieldLabel: _('ID_PASSWORD'),//'Password',
        id:'Password',
        name:'Password',
        inputType: 'password',
        width: 200,
        allowBlank: true,
        disabled : true,
        listeners : {
          'change' : function() {
            if (Ext.getCmp('Password').getValue() != '') {
              Ext.getCmp('PasswordHide').setValue('');
            }
          }
        }
      },
      {
        xtype:      "textfield",
        id:         "fromMail",
        name:       "fromMail",
        fieldLabel: _('ID_FROM_EMAIL'),  //"From Mail",
        width:      250,
        disabled:   true,
        vtype:'email'
      },
      {
        xtype: 'textfield',
        fieldLabel: _('ID_FROM_NAME'),
        id:'eFromName',
        name:'eFromName',
        width: 250,
        disabled : true
      },
      {
        id:'UseSecureConnection',
        name:'UseSecureConnection',
        xtype: 'radiogroup',
        fieldLabel: _('USE_SECURE_CONNECTION'),//'Use Secure Connection',
        columns: 3,
        width: 200,
        disabled : true,
        vertical: true,
        items: [
          {boxLabel: 'No',inputValue: 'No',name: 'UseSecureConnection',checked:true},
          {boxLabel: 'TLS', inputValue: 'tls',name: 'UseSecureConnection'},
          {boxLabel: 'SSL', inputValue: 'ssl',name: 'UseSecureConnection'}
        ]
      },
      {
        xtype: 'checkbox',
        boxLabel: _('SEND_TEST_MAIL'),//'Send a test mail' ,
        id:'SendaTestMail',
        name:'SendaTestMail',
        disabled : true,
        listeners: {
          check: function(EnableEmailNotifications, checked) {
            if(checked) {
              Ext.getCmp('eMailto').setVisible(true);
              Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(true);
              Ext.getCmp('eMailto').setValue('');
            }
            else{
              Ext.getCmp('eMailto').setVisible(false);
              Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(false);
              Ext.getCmp('eMailto').setValue('  ');
            }
          }
        }
      },
      {
        xtype: 'textfield',
        fieldLabel: _('MAIL_TO'),//'Mail to',
        id:'eMailto',
        name:'eMailto',
        width: 200,
        disabled : true,
        allowBlank: false
      },
      tb
    ]
  });

  loadfields = function(){
    Ext.Ajax.request({
      url: '../adminProxy/loadFields',
      params: { CFG_UID: 'Emails' },
      success: function(r,o) {
        var res = Ext.decode(r.responseText);
        if (! res.data)
          return;
        if (res.success) {
            if (res.data.MESS_ENABLED == 1) {
                Ext.getCmp('EnableEmailNotifications').setValue(res.data.MESS_ENABLED);
                Ext.getCmp('EmailEngine').setValue(res.data.MESS_ENGINE);

                if (Ext.getCmp('EmailEngine').getValue()== 'MAIL') {
                  Ext.getCmp('Server').setVisible(false);
                  Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(false); // hide label
                  Ext.getCmp('Port').setVisible(false);
                  Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(false);
                  Ext.getCmp('RequireAuthentication').setVisible(false);
                  Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(false);
                  Ext.getCmp('AccountFrom').setVisible(false);
                  Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(false);
                  Ext.getCmp('Password').setVisible(false);
                  Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);

                  //Ext.getCmp('eFromName').setVisible(false);
                  //Ext.getCmp('eFromName').getEl().up('.x-form-item').setDisplayed(false);

                  Ext.getCmp('UseSecureConnection').setVisible(false);
                  Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(false);

                  //Ext.getCmp("fromMail").setVisible(false);
                  //Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(false);

                  if (typeof (res.data.MESS_FROM_MAIL) != "undefined"){
                     Ext.getCmp("fromMail").setValue(res.data.MESS_FROM_MAIL);
                  } else {
                     Ext.getCmp("fromMail").setValue("");
                  }
                } else {
                  Ext.getCmp('Server').setVisible(true);
                  Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(true); // hide label
                  Ext.getCmp('Port').setVisible(true);
                  Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(true);
                  Ext.getCmp('RequireAuthentication').setVisible(true);
                  Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(true);
                  Ext.getCmp('AccountFrom').setVisible(true);
                  Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(true);
                  //Ext.getCmp("fromMail").setVisible(true);
                  //Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(true);

                  if (Ext.getCmp('RequireAuthentication').getValue() === true)
                  {
                    Ext.getCmp('Password').setVisible(true);
                    Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(true);
                    // Ext.getCmp('AccountFrom').allowBlank = false;
                  } else {
                    Ext.getCmp('Password').setVisible(false);
                    Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
                    // Ext.getCmp('AccountFrom').allowBlank = true;
                  }

                  //Ext.getCmp('eFromName').setVisible(true);
                  //Ext.getCmp('eFromName').getEl().up('.x-form-item').setDisplayed(true);

                  if(!Ext.getCmp('UseSecureConnection').getValue()) {
                    Ext.getCmp('UseSecureConnection').setValue('No');
                  }

                  Ext.getCmp('UseSecureConnection').setVisible(true);
                  Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(true);

                  Ext.getCmp('Server').setValue(res.data.MESS_SERVER);
                  Ext.getCmp('Port').setValue(res.data.MESS_PORT);
                  Ext.getCmp('RequireAuthentication').setValue(res.data.MESS_RAUTH);
                  Ext.getCmp('AccountFrom').setValue(res.data.MESS_ACCOUNT);
                  Ext.getCmp('Password').setValue(res.data.MESS_PASSWORD);
                  Ext.getCmp('PasswordHide').setValue(Ext.getCmp('Password').getValue());

                  if (typeof (res.data.MESS_FROM_MAIL) != "undefined"){
                     Ext.getCmp("fromMail").setValue(res.data.MESS_FROM_MAIL);
                  } else {
                     Ext.getCmp("fromMail").setValue("");
                  }

                  if (res.data.SMTPSecure == 'none') {
                    Ext.getCmp('UseSecureConnection').setValue('No');
                  }
                  else {
                    Ext.getCmp('UseSecureConnection').setValue(res.data.SMTPSecure);
                  }
                }

                Ext.getCmp('SendaTestMail').setValue(res.data.MESS_TRY_SEND_INMEDIATLY);

                if(!res.data.MAIL_TO) {
                  Ext.getCmp('eMailto').setValue('');
                }
                else {
                  Ext.getCmp('eMailto').setValue(res.data.MAIL_TO);
                }
                if(!res.data.MESS_FROM_NAME) {
                  Ext.getCmp('eFromName').setValue('');
                } else {
                  Ext.getCmp('eFromName').setValue(res.data.MESS_FROM_NAME);
                }

            }
        }
      }
    });
  }

  loadfields();

  var frm = new Ext.FormPanel({
    title: '&nbsp',
    id:'EMailFields',
    labelWidth: 150,
    width:600,
    labelAlign:'right',
    autoScroll: true,
   // bodyStyle:'padding:2px',
    waitMsgTarget : true,
    frame: true,
    defaults: {
      allowBlank: false,
      msgTarget: 'side',
      align:'center'
    },
    items: [EMailFields ]
  });
  //render to process-panel
  frm.render(document.body);
  combo.setVisible(false);
  combo.getEl().up('.x-form-item').setDisplayed(false); // hide label
  Ext.getCmp('Server').setVisible(false);
  Ext.getCmp('Server').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('Port').setVisible(false);
  Ext.getCmp('Port').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('RequireAuthentication').setVisible(false);
  Ext.getCmp('RequireAuthentication').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('AccountFrom').setVisible(false);
  Ext.getCmp('AccountFrom').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('Password').setVisible(false);
  Ext.getCmp('Password').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('SendaTestMail').setVisible(false);
  Ext.getCmp('SendaTestMail').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('eMailto').setVisible(false);
  Ext.getCmp('eMailto').getEl().up('.x-form-item').setDisplayed(false);
  //Ext.getCmp('eFromName').setVisible(false);
  //Ext.getCmp('eFromName').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('UseSecureConnection').setVisible(false);
  Ext.getCmp('UseSecureConnection').getEl().up('.x-form-item').setDisplayed(false);
  Ext.getCmp('Test').setVisible(false);
  Ext.getCmp('SaveChanges').setVisible(false);
  Ext.getCmp('UnEdit').setVisible(false);
  Ext.getCmp('labelUn').setVisible(false);
  //Ext.getCmp("fromMail").setVisible(false);
  //Ext.getCmp("fromMail").getEl().up('.x-form-item').setDisplayed(false);

});

var testConnForm = new Ext.FormPanel({
  collapsible: false,
  maximizable: true,
  width:445,
  autoHeight:true,
  frame:true,
  autoDestroy : true,
  monitorValid : true,
  plain: true,
  waitMsgTarget: true,
  items:[{
    xtype  : 'fieldset',
    layout : 'form',
    id:'testConnField',
    title: _('TESTING_EMAIL_CONF'),//'Testing email configuration',
    labelWidth:20,
    items : [
      {
        xtype: 'label', fieldLabel: ' ',
        id:'step1', width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label', fieldLabel: '     ',
        id:'result1',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      },
      {
        xtype: 'label',
        fieldLabel: ' ',
        id:'step2',
        width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label', fieldLabel: '     ',
        id:'result2',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      },
      {
        xtype: 'label',
        fieldLabel: ' ',
        id:'step3',
        width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label', fieldLabel: '     ',
        id:'result3',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      },
      {
        xtype: 'label',
        fieldLabel: ' ',
        id:'step4',
        width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label',
        fieldLabel: '     ',
        id:'result4',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      },
      {
        xtype: 'label',
        fieldLabel: ' ',
        id:'step5',
        width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label',
        fieldLabel: '     ',
        id:'result5',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      }
    ]
  }],
  buttons: [
    {
      text:_('ID_DONE'),
      id: 'done',
      handler: function(){
        testEmailWindow.hide();
      }
    }
  ]
});

var testConnFormMail = new Ext.FormPanel({
  collapsible: false,
  maximizable: true,
  width:445,
  autoHeight:true,
  frame:true,
  autoDestroy : true,
  monitorValid : true,
  plain: true,
  waitMsgTarget: true,
  items:[{
    xtype  : 'fieldset',
    layout : 'form',
    id:'testConnFieldMail',
    title: _('TESTING_EMAIL_CONF'),//'Testing email configuration',
    labelWidth:20,
    items : [
      {
        xtype: 'label', fieldLabel: ' ',
        id:'step11', width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label', fieldLabel: '     ',
        id:'result11',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      },
      {
        xtype: 'label',
        fieldLabel: ' ',
        id:'step12',
        width: 300,
        labelSeparator:''
      },
      {
        xtype: 'label', fieldLabel: '     ',
        id:'result12',
        width: 300,
        labelSeparator:'',
        style : 'font-size: 11px;'
      }
    ]
  }],
  buttons: [
    {
      text:_('ID_DONE'),
      id: 'doneMail',
      handler: function(){
        testEmailWindowMail.hide();
      }
    }
  ]
});

var testEmailWindow = new Ext.Window({
  width: 470,
  closable:false,
  plain: true,
  modal: true,
  autoHeight: true,
  layout: 'fit',
  y: 82,
  items: testConnForm,
  draggable: false,
  resizable: false
});

var testEmailWindowMail = new Ext.Window({
  width: 470,
  closable:false,
  plain: true,
  modal: true,
  autoHeight: true,
  layout: 'fit',
  y: 82,
  items: testConnFormMail,
  draggable: false,
  resizable: false
});

var params;
var count = 0;
var EditMethod = function()
{
  Ext.getCmp('EnableEmailNotifications').setDisabled(false);
  Ext.getCmp('EmailEngine').setDisabled(false);
  Ext.getCmp('Server').setDisabled(false);
  Ext.getCmp('Port').setDisabled(false);
  Ext.getCmp('RequireAuthentication').setDisabled(false);
  Ext.getCmp('AccountFrom').setDisabled(false);
  Ext.getCmp('Password').setDisabled(false);
  Ext.getCmp('SendaTestMail').setDisabled(false);
  Ext.getCmp('eMailto').setDisabled(false);
  Ext.getCmp('eFromName').setDisabled(false);
  Ext.getCmp('UseSecureConnection').setDisabled(false);
  Ext.getCmp('Test').setVisible(true);
  Ext.getCmp('SaveChanges').setVisible(true);
  Ext.getCmp('UnEdit').setVisible(true);
  Ext.getCmp('Edit').setVisible(false);
  Ext.getCmp('label').setVisible(false);
  Ext.getCmp('labelUn').setVisible(true);
  Ext.getCmp("fromMail").setDisabled(false);
}

var UnEditMethod = function()
{
  Ext.getCmp('EnableEmailNotifications').setDisabled(true);
  Ext.getCmp('EmailEngine').setDisabled(true);
  Ext.getCmp('Server').setDisabled(true);
  Ext.getCmp('Port').setDisabled(true);
  Ext.getCmp('RequireAuthentication').setDisabled(true);
  Ext.getCmp('AccountFrom').setDisabled(true);
  Ext.getCmp('Password').setDisabled(true);
  Ext.getCmp('SendaTestMail').setDisabled(true);
  Ext.getCmp('eMailto').setDisabled(true);
  Ext.getCmp('eFromName').setDisabled(true);
  Ext.getCmp('UseSecureConnection').setDisabled(true);
  Ext.getCmp('Test').setVisible(false);
  Ext.getCmp('SaveChanges').setVisible(false);
  Ext.getCmp('UnEdit').setVisible(false);
  Ext.getCmp('Edit').setVisible(true);
  Ext.getCmp('label').setVisible(true);
  Ext.getCmp('labelUn').setVisible(false);
  Ext.getCmp("fromMail").setDisabled(true);
}
var testMethod = function()
{
  var typeTest = Ext.getCmp('EmailEngine').getValue();

  switch (typeTest)
  {
    case 'MAIL':
      if (  Ext.getCmp('SendaTestMail').getValue() == true &&
            ( Ext.getCmp('eMailto').getValue() == '' ||
              /^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i.test(Ext.getCmp('eMailto').getValue()) != true ) ) {
        Ext.MessageBox.show({
          title: _('ID_ERROS'),
          msg: _('ID_MAIL_TO_NOT_VALID_ADDRESS'),
          buttons: Ext.MessageBox.OK,
          animEl: 'mb9',
          icon: Ext.MessageBox.ERROR
        });

        return false;
      }

      params = {
        typeTest  : 'MAIL',
        request   : 'mailTestMail_Show',
        mail_to   : 'admin@processmaker.com',
        send_test_mail  : 'yes',
        from_mail : Ext.getCmp("fromMail").getValue(),
        from_name : Ext.getCmp("eFromName").getValue()
      };

      Ext.getCmp('step11').setText('<span id="rstep11"></span>  '+_('LOGIN_VERIFY_MSG')+' <b> Mail Transport Agent </b>', false);
      Ext.getCmp('step12').setText('<span id="rstep12"></span>  '+_('SENDING_TEST_EMAIL')+' [<b>'+ Ext.getCmp('eMailto').getValue() +'</b>]...<b>', false);

      Ext.getCmp('step11').setVisible(false);
      Ext.getCmp('step12').setVisible(false);
      Ext.getCmp('result11').setVisible(false);
      Ext.getCmp('result12').setVisible(false);

      Ext.getCmp('doneMail').enable();
      Ext.getCmp('SaveChanges').disable();

      Ext.getCmp('EMailFields').disable();
      testEmailWindowMail.show();
      Ext.getCmp('EMailFields').enable();

      execTest(11);
      break;
    case 'PHPMAILER':
      if((Ext.getCmp('Port').getValue()==null)||(Ext.getCmp('Port').getValue()=='')) {
        Ext.getCmp('Port').setValue('25');
      }

      if (Ext.getCmp('RequireAuthentication').checked){
        if (Ext.getCmp('Password').getValue()=='') {
          if (Ext.getCmp('PasswordHide').getValue()=='') {
            PMExt.warning(_('ID_WARNING'),_('ID_PASSWD_REQUIRED'));
            return false;
          }
        }
      }
      var x                   = Ext.getCmp('UseSecureConnection').getValue();
      var UseSecureConnection = x.getGroupValue();
      var count=0;
      var create=true;

      params = {
        typeTest      : 'PHPMAILER',
        server        : Ext.getCmp('Server').getValue(),
        user          : Ext.getCmp('AccountFrom').getValue(),
        passwd        : Ext.getCmp('Password').getValue(),
        passwdHide    : Ext.getCmp('PasswordHide').getValue(),
        port          : Ext.getCmp('Port').getValue(),
        req_auth      : Ext.getCmp('RequireAuthentication').getValue(),
        UseSecureCon  : UseSecureConnection,
        SendaTestMail : Ext.getCmp('SendaTestMail').getValue() ,
        eMailto       : Ext.getCmp('eMailto').getValue(),
        login         : Ext.getCmp('AccountFrom').getValue(),
        fromMail      : Ext.getCmp("fromMail").getValue(),
        fromName      : Ext.getCmp("eFromName").getValue()
      };

      Ext.getCmp('step1').setText('<span id="rstep1"></span>  '+_('RESOLVING_NAME')+' <b>'+params.server+'</b>', false);
      Ext.getCmp('step2').setText('<span id="rstep2"></span>  '+_('ID_CHECK_PORT')+' <b>'+params.port+'</b>',false);
      Ext.getCmp('step3').setText('<span id="rstep3"></span>  '+_('ESTABLISHING_CON_HOST')+' <b>'+params.server+':'+params.port+'</b>',false);
      Ext.getCmp('step4').setText('<span id="rstep4"></span>  '+_('LOGIN_AS')+' [<b>'+params.login+'</b>] '+_('ID_ON')+' '+params.server+' '+_('SMTP_SERVER')+' <b>',false);
      Ext.getCmp('step5').setText('<span id="rstep5"></span>  '+_('SENDING_TEST_EMAIL')+' [<b>'+params.eMailto +'</b>]...<b>', false);

      Ext.getCmp('step1').setVisible(false);
      Ext.getCmp('step2').setVisible(false);
      Ext.getCmp('step3').setVisible(false);
      Ext.getCmp('step4').setVisible(false);
      Ext.getCmp('step5').setVisible(false);
      Ext.getCmp('result1').setVisible(false);
      Ext.getCmp('result2').setVisible(false);
      Ext.getCmp('result3').setVisible(false);
      Ext.getCmp('result4').setVisible(false);
      Ext.getCmp('result5').setVisible(false);

      Ext.getCmp('done').enable();
      Ext.getCmp('SaveChanges').disable();

      Ext.getCmp('EMailFields').disable();
      testEmailWindow.show();
      Ext.getCmp('EMailFields').enable();

      execTest(1);
      break;
  }
  return true;
};

function execTest(step) {
  if (step == 6) return false;
  if (step == 13) return false;

  if ((step == 5) && (params.SendaTestMail == false))
    return false;
  if ((step == 12) && (Ext.getCmp('SendaTestMail').getValue() != true))
    return false;

  document.getElementById('rstep'+step).innerHTML = '<img width="13" height="13" border="0" src="/images/ajax-loader.gif">';
  Ext.getCmp('step'+step).setVisible(true);

  params.step = step;
  params.mail_to = (params.step == 12) ? Ext.getCmp('eMailto').getValue() : params.mail_to;

  Ext.Ajax.request({
    url: '../adminProxy/testConnection',
    method:'POST',
    params: params,
    waitMsg: _('ID_UPLOADING_PROCESS_FILE'),
    success: function(r,o){
      var resp = Ext.util.JSON.decode(r.responseText);

      if (resp.success) {
        img = '/images/dialog-ok-apply.png';
        Ext.getCmp('SaveChanges').enable();
        colorMsg = 'color:#00FF00';
      }
      else {
        img = '/images/delete.png';
        Ext.getCmp('SaveChanges').disable();
        colorMsg = 'color:#FF0000';
      }

      document.getElementById('rstep'+step).innerHTML = '<img width="13" height="13" border="0" src="'+img+'">';

      if(resp.msg) {
        document.getElementById('result'+step).innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="' + colorMsg + ';">'+resp.msg+'</span>';
        Ext.getCmp('result'+step).setVisible(true);
      }

      execTest(step+1);
    }
  });
}

saveMethod=function() {
  var x = Ext.getCmp('UseSecureConnection').getValue();
  var UseSecureConnection = x.getGroupValue();
  Ext.Ajax.request({
    url: '../adminProxy/saveConfiguration',
    method:'POST',
    params:{
      type:'type',
      server:Ext.getCmp('Server').getValue(),
      db_name:'db_name',
      from:Ext.getCmp('AccountFrom').getValue(),
      passwd:Ext.getCmp('Password').getValue(),
      passwdHide:Ext.getCmp('PasswordHide').getValue(),
      port:Ext.getCmp('Port').getValue(),
      req_auth:Ext.getCmp('RequireAuthentication').getValue(),
      UseSecureCon:UseSecureConnection,
      SendaTestMail : Ext.getCmp('SendaTestMail').getValue() ,
      eMailto :  Ext.getCmp('eMailto').getValue(),
      FromName: Ext.getCmp('eFromName').getValue(),
      EnableEmailNotifications : Ext.getCmp('EnableEmailNotifications').getValue(),
      EmailEngine : Ext.getCmp('EmailEngine').getValue(),
      background: 'true',
      fromMail:Ext.getCmp("fromMail").getValue()
    },
    success: function(r){
      var i = Ext.decode(r.responseText);
      PMExt.notify(_('ID_CHANGES_SAVED'),i.msg);
    }
  });
  UnEditMethod();
}
