{
    "xdsVersion": "2.2.2",
    "frameworkVersion": "ext42",
    "internals": {
        "type": "Ext.form.Panel",
        "reference": {
            "name": "items",
            "type": "array"
        },
        "codeClass": null,
        "userConfig": {
            "designer|snapToGrid": 5,
            "frame": true,
            "height": 310,
            "width": 379,
            "designer|userClassName": "NewPaymentsForm",
            "designer|userAlias": "newpaymentsform",
            "layout": "absolute",
            "bodyPadding": 10,
            "title": null,
            "url": "data/getDataFunctions.php?task=InsertItem"
        },
        "cn": [
            {
                "type": "Ext.form.field.Text",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 15,
                    "itemId": "pid",
                    "fieldLabel": "PID",
                    "labelAlign": "right",
                    "name": "pid"
                }
            },
            {
                "type": "Ext.form.field.Text",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 165,
                    "fieldLabel": "Balance",
                    "labelAlign": "right",
                    "name": "Balance"
                }
            },
            {
                "type": "Ext.form.field.Text",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 135,
                    "fieldLabel": "Amount",
                    "labelAlign": "right",
                    "name": "Amount"
                }
            },
            {
                "type": "Ext.form.field.Text",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 45,
                    "fieldLabel": "Total Time",
                    "labelAlign": "right",
                    "name": "totalTime"
                }
            },
            {
                "type": "Ext.form.field.ComboBox",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 105,
                    "width": 305,
                    "fieldLabel": "Payment",
                    "labelAlign": "right",
                    "name": "Payment",
                    "displayField": "PayType",
                    "minChars": 2,
                    "queryMode": "local",
                    "store": "PayTypeStore",
                    "typeAhead": true,
                    "valueField": "CatID"
                }
            },
            {
                "type": "Ext.form.field.ComboBox",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 10,
                    "layout|y": 75,
                    "itemId": "CatID",
                    "width": 305,
                    "fieldLabel": "Payment Type",
                    "labelAlign": "right",
                    "name": "PaymentType",
                    "store": [
                        "[[\"1\",\"Pay\"],[\"2\",\"Benefit\"],[\"3\",\"Deduct\"]]"
                    ]
                },
                "configAlternates": {
                    "store": "array"
                }
            },
            {
                "type": "Ext.button.Button",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 40,
                    "layout|y": 210,
                    "height": 45,
                    "itemId": "cmdSaveEmpPayment",
                    "width": 105,
                    "text": "<b>Save</b>"
                }
            },
            {
                "type": "Ext.button.Button",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 225,
                    "layout|y": 210,
                    "height": 45,
                    "itemId": "cmdClose",
                    "width": 105,
                    "text": "<b>Close</b>"
                }
            },
            {
                "type": "Ext.form.field.Text",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "layout|x": 105,
                    "layout|y": 265,
                    "itemId": "formStatus",
                    "fieldLabel": null,
                    "name": "formStatus",
                    "readOnly": true
                }
            }
        ]
    },
    "linkedNodes": {},
    "boundStores": {
        "3e8726c8-4e67-4e98-a99f-fbfa60b25a55": {
            "type": "jsonstore",
            "reference": {
                "name": "items",
                "type": "array"
            },
            "codeClass": null,
            "userConfig": {
                "autoLoad": true,
                "model": "PayTypes",
                "storeId": "PayTypeStore",
                "designer|userClassName": "PayTypeStore",
                "designer|userAlias": "paytypestore"
            },
            "cn": [
                {
                    "type": "Ext.data.proxy.Ajax",
                    "reference": {
                        "name": "proxy",
                        "type": "object"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "url": "data/getDataFunctions.php?task=getPayTypes"
                    },
                    "cn": [
                        {
                            "type": "Ext.data.reader.Json",
                            "reference": {
                                "name": "reader",
                                "type": "object"
                            },
                            "codeClass": null,
                            "userConfig": {
                                "root": "payTypes"
                            }
                        }
                    ]
                }
            ]
        }
    },
    "boundModels": {
        "7dd6ec24-ae1d-44fd-91d7-a9415b114f9d": {
            "type": "Ext.data.Model",
            "reference": {
                "name": "items",
                "type": "array"
            },
            "codeClass": null,
            "userConfig": {
                "designer|userClassName": "PayTypes",
                "designer|userAlias": "paytypes"
            },
            "cn": [
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "ID"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "CatID"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "PayType"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "Fixed"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "Contribution"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "gl_acc"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "gl_desc"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "Posted"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "Interest"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "InterestCode"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "InterestName"
                    }
                },
                {
                    "type": "Ext.data.Field",
                    "reference": {
                        "name": "fields",
                        "type": "array"
                    },
                    "codeClass": null,
                    "userConfig": {
                        "name": "Recurrent"
                    }
                }
            ]
        }
    }
}