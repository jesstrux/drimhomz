<style>

    #dp{
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 15px;
        position: relative;
    }

    #dp > img{
        width: 100%;
        cursor: pointer;
    }

    #dp #loadingDp{
        position: absolute;
        height: 100%; width: 100%;
        background-color: rgba(255,255,255,0.8);
        z-index: 9;
        opacity: 0;
        pointer-events: none;
    }

    #dp.loading-dp #loadingDp{
        opacity: 1;
        pointer-events: auto;
    }
        #newUser{
            /*margin-top: 40px;*/
        }

        #newUser #outer{
            margin-top: 40px;
            max-width: 900px;
        }

        #newUser #wrapper{
            box-shadow: 0 0 2px rgba(0,0,0,0.35);
        }

        #newUser #dpEditor, #newUser #editorForm{
            padding: 35px 30px;
            /*background-color: purple;*/
        }


        #newUser #editorForm{
            padding-left: 60px;
        }

        #newUser #editorForm h3{
            margin-top: 0;
            color: #000;
        }




        #savebtnWrapper{
            margin-top: 30px;
        }

        #savebtnWrapper .btn{
            float: right;
        }

        @media all and (max-width: 780px) {
    #info{
    padding-top: 10px;
            }
            #newUser #outer{
                margin-top: 10px;
            }
            #newUser #wrapper{
                box-shadow: none;
            }

            #newUser #dpEditor{
                display: none;
            }

            #newUser #editorForm{
                padding: 10px;
                width: 100%;
            }

            .setup-field{
    width: 100%;
    -webkit-flex-direction: column;
                -moz-flex-direction: column;
                -ms-flex-direction: column;
                -o-flex-direction: column;
                flex-direction: column;
                -ms-align-items: flex-start;
                align-items: flex-start;
            }

            .setup-field label{

}

            .setup-field .col-md-8{
    padding: 0;
    margin-top: 5px;
                width: 100%;
            }

            .setup-field .form-control{
    width: 100% !important;
}
        }

        @media all and (min-width: 781px) {
    #editorForm{
    width: 96%
            }
            #info{
                padding-top: 30px;
            }
            #savebtnWrapper{
                margin-top: 30px;
                margin-right: 15px;
            }
        }
    </style>