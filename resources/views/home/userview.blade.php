<div class="image-grid">
    <style>
        body{
            background-color: #eee;
        }
        #container{
            list-style: none;
            display: block;
            position: relative;
            padding: 0;
            margin: 0;
        }
        .grid-sizer, .dh-card{
            width: calc(20% - 10px);
            /*background-color: red;*/
            /*display: block;*/
        }
        .dh-card{
            display: inline-block;
            margin: 0 5px; margin-bottom: 15px; border-radius: 10px;
            margin: 0;
        }

        .dh-card .image{
            border-radius: 10px 10px 0 0;
        }

        @media all and (max-width: 900px) {
            .grid-sizer, .dh-card{
                width: calc(33.333% - 10px);
            }
        }

        @media all and (max-width: 768px) {
            .grid-sizer, .dh-card{
                width: calc(50% - 10px);
            }
        }

        @media all and (max-width: 406px) {
            .grid-sizer, .dh-card{
                width: calc(100% - 10px);
            }
        }

        .dh-card p{
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            -ms-text-overflow: ellipsis;
            text-overflow: ellipsis;
        }
    </style>

        <ul id="container">
            
        </ul>
        <!-- <div class="empty-message">There are no featured houses.</div> -->
</div>