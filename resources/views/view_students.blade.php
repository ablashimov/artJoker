<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to the task</title>
        <style>
            @import url(//fonts.googleapis.com/css?family=Lato:700);

            body {
                margin: 0;
                font-family: 'Lato', sans-serif;
                text-align: center;
                color: #999;
            }

            .header {
                width: 100%;
                left: 0px;
                top: 5%;
                text-align: left;
                border-bottom: 1px #999 solid;
            }

            .student-table {
                width: 100%;
            }

            table.student-table th {
                background-color: #C6C6C6;
                text-align: left;
                color: white;
                padding: 7px 3px;
                font-weight: 700;
                font-size: 18px;
            }

            table.student-table tr.odd {
                text-align: left;
                padding: 5px;
                background-color: #F9F9F9;
            }

            table.student-table td {
                text-align: left;
                padding: 5px;
            }

            a, a:visited {
                text-decoration: none;
                color: #999;
            }

            h1 {
                font-size: 32px;
                margin: 16px 0 0 0;
            }

            ul.pagination {
                margin: 0; /* Обнуляем значение отступов */
                padding: 4px; /* Значение полей */
            }

            ul.pagination li {
                display: inline; /* Отображать как строчный элемент */
                margin-right: 5px; /* Отступ слева */
                padding: 3px; /* Поля вокруг текста */
            }

            .has-error {
                color: red
            }
        </style>
        <script src="{{ asset('js/app.js') }}"></script>
    </head>

    <body>
        @if( count($students) > 0 )
            <div class="header">
                <div><img src="/images/logo_sm.jpg" alt="Logo" title="logo"></div>
                <div style='margin: 10px;  text-align: left'>
                    <input type="button" onClick="exportToCsv()" value="Export selected fields"/>
                    <input type="button" onClick="exportToCsv('all')" value="Export all"/>
                    <input type="button" onClick="exportStudentsHaveAllCurses()" value="Export students which register all courses"/>
                </div>
                <div style='margin: 10px;  text-align: left' id="div_error"></div>
            </div>

            <form>
                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                <div style='margin: 10px; text-align: center;'>
                    <table class="student-table">
                        <tr>
                            <th></th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>University</th>
                            <th>Course</th>
                        </tr>
                        @foreach($students as $student)
                            <tr>
                                <td><input type="checkbox" name="studentId" value="{{$student->id}}"></td>
                                <td style=' text-align: left;'>{{$student->first_name}}</td>
                                <td style=' text-align: left;'>{{$student->surname}}</td>
                                <td style=' text-align: left;'>{{$student->email}}</td>
                                <td style=' text-align: left;'>
                                    @foreach($student->courses as $course)
                                    <p>{{$course->university}}</p>
                                    @endforeach
                                </td>
                                <td style=' text-align: left;'>
                                    @foreach($student->courses as $course)
                                        <p>{{$course->course_name}}</p>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $students->links() }}
                </div>
            </form>
        @else
            <tr>
                <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
            </tr>
        @endif
    </body>
    <script>
        function exportToCsv(type) {
            var data;
            if (!type) {
                data = [];
                $("input:checkbox[name=studentId]:checked").each(function () {
                    data.push($(this).val());
                });
            }else {
                data = 'all';
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                data: {'data': data},
                url: "{{route('students.export')}}",
                error: function (errors) {
                    errorFields(errors)
                },
                success: function (response) {
                    $('#div_error').removeClass("has-error").text('');

                    download(response);
                }
            });
        }

        function exportStudentsHaveAllCurses() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'get',
                url: "{{route('students.export-register-all-courses')}}",
                error: function (errors) {
                    errorFields(errors)
                },
                success: function (response) {
                    $('#div_error').removeClass("has-error").text('');

                    download(response);
                }
            });
        }

        function download(response) {
            let link = document.createElement('a');
            link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(response));
            link.setAttribute('download', 'Students.csv');
            document.body.appendChild(link);
            link.click();
        }

        function errorFields(errors) {
            if (!errors.responseText) {
                return false
            }

            errors = JSON.parse(errors.responseText);
            var key = Object.keys(errors);
            key.forEach(function (id) {
                $('#div_error').addClass("has-error").text(errors[id][0]);
            });
        }
    </script>

</html>
