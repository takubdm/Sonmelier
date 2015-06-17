call `music_list`.`create_list` (
	"TestList",
	"Test List",
	"http://www.google.co.jp/",
	1,
	"Sample Category",
	"Alexi Laiho
Janne Warman
Henkka T Blacksmith
Jaska Raatikainen
Roope Latvala"
);

select * from `music_list`.`view_artist_info_full`;
