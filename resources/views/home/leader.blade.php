<x-user-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex text-center content-center">
                        <img class="max-w-full rounded-lg" style="margin: 0 auto;" src="{{asset('images/lead.jpg')}}" alt="">
                    </div>


                    <div class="relative overflow-x-auto">
                        <table class="w-full text-lg text-center ajax-table">
                            <thead class="text-lg bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Rank</th>
                                <th scope="col" class="px-6 py-3">Player Name</th>
                                <th scope="col" class="px-6 py-3">Score</th>
{{--                                <th scope="col" class="px-6 py-3">Duration</th>--}}
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script type="module">
        window.jQuery(function () {
            var table = window.jQuery('.ajax-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 15,
                ajax:{
                    url:'{{ route('player.leaderboard_ajax') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                    error: function (xhr, error, code) {
                        setInterval(function () {location.reload();}, 1000*5);
                    }
                },
                dom: 'srt',
                "createdRow": function( row, data, dataIndex ) {
                    $(row).addClass( 'bg-white border-b dark:bg-gray-800 dark:border-gray-700' );
                },
                columns: [
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'DT_RowIndex' , name: 'DT_RowIndex', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'name', name: 'name', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'score', name: 'score', orderable: false, searchable: false},
                    // {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'duration', name: 'duration', orderable: false, searchable: false}

                ]
            });

            setInterval(function () {table.ajax.reload();}, 1000*5);



        });
    </script>

</x-user-layout>
