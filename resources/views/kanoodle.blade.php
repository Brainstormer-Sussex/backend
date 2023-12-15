<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kanoodle</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style type="text/css">
            .st {
                display: inline-table;
                margin: 5px;
                border: none;
                border-collapse: collapse;
            }

            .sr {
                height: 12px;
            }

            .sc {
                width: 12px;
                padding: 0px;
            }

            .wt {
                display: inline-table;
                margin: 5px;
                border: none;
                border-collapse: collapse;
            }

            .wr {
                height: 50px;
            }

            .wc {
                width: 50px;
                padding: 0px;
            }

            .cL {
                background-color: rgb(46, 73, 117);
            }

            .cI {
                background-color: rgb(59, 130, 246);
            }

            .ci {
                background-color:rgb(253, 224, 71);
            }

            .cl {
                background-color: rgb(244, 114, 182);
            }

            .cN {
                background-color: rgb(251, 146, 60);
            }

            .cW {
                background-color: rgb(165, 243, 252);
            }

            .cV {
                background-color: rgb(129, 140, 248);
            }

            .cS {
                background-color: rgb(239, 68, 68);
            }

            .cU {
                background-color: rgb(93, 99, 116);
            }

            .cP {
                background-color: rgb(192, 132, 252);
            }

            .cX {
                background-color: rgb(165, 91, 91);
            }

            .cY {
                background-color: rgb(74, 222, 128);
            }

            .btn {
                border-top: none;
            }

            .bts {
                border-top: 1px solid black;
            }

            .btd {
                border-top: 1px dotted black;
            }

            .bbn {
                border-bottom: none;
            }

            .bbs {
                border-bottom: 1px solid black;
            }

            .bbd {
                border-bottom: 1px dotted black;
            }

            .bln {
                border-left: none;
            }

            .bls {
                border-left: 1px solid black;
            }

            .bld {
                border-left: 1px dotted black;
            }

            .brn {
                border-right: none;
            }

            .brs {
                border-right: 1px solid black;
            }

            .brd {
                border-right: 1px dotted black;
            }
        </style>
    </head>
    <body class="antialiased">
        <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="{{asset('js/kanoodle/handler.js')}}"></script>

        <button id="startbtn" onclick="StartWorker()">Start Worker</button>
        <p>Solutions found: <span id="solcnt">0</span><button id="stopbtn" onclick="StopWorker()">Stop</button></p>
        <div id="work"></div>
        <div id="results"></div>
        <div id="debug"></div>
    </body>
</html>
