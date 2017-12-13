#! /bin/bash
# this is a comment
# echo "hello world"

# echo Our shell name is $BASH
# echo Version is $BASH_VERSION
# echo Home directory $HOME
# echo Current working directory $PWD

# variable
# name=Colin
# echo My name is $name

# Read Inputs
# echo "Enter names: "
# read name1 name2 name3
# echo "Entered name: $name1, $name2, $name3"

# display prompt
# read -p 'username: ' user_var
# read -sp 'password: ' pass_var
# echo
# echo "username is $user_var"
# echo "password is $pass_var"

# Passing Argument
# $0 is refer to the script name
# $1 is refer to the first argument
# echo $0 $1 $2 $3 ' > echo $1 $2 $3'
# args=("$@")
# $0 is the first argument
# echo ${args[0]} ${args[1]} ${args[2]}
# echo $@

# conditional statement
# count=10
# word=a
# # if [ $count -gt 9 ]
# if [ $word == "abccc" ]
# then
#   echo 'condition is true'
# elif [ $word == "a" ]
# then
# 	echo 'word is a'
# else
#   echo 'condition is false'
# fi

# # File Test operator
# # -e: Interprate
# # \c: cursor stay in the current line 
# echo -e "Enter the name of the file : \c"
# read file_name
# # -e: if the file exist
# # -f: if the file exist and it is a regular file
# # -d: if the file exist and it is a directive
# # -s: check if the file is empty
# # -r, -w, -x: check the permission of the file
# if [ -e $file_name ]
# then
#   echo "$file_name found"
# else
#   echo "$file_name not found"
# fi

# # Output to the end of the file
# # >>: append
# # >: overwrite
# if [ -f $file_name ]
# then
#   if [ -w $file_name ]
#   then
#     echo "Type some text. To quite press ctrl+d"
#     cat >> $file_name
#   else
#     echo "The file do not have the write permission"
#   fi
# else
#   echo "$file_name not found"
# fi

# # Logic operator
# # AND: &&  -a
# # OR: ||   
# age=2
# if [ $age -gt 18 ] && [ $age -lt 30 ]
# # if [ $age -gt 18 -a $age -lt 30 ]
# then
#   echo "valid age"
# else
#   echo "age not valid"
# fi

# # Arithmetic
# num1=20
# num2=5
# echo $(( num1 + num2 ))
# echo $(( num1 - num2 ))
# echo $(( num1 * num2 ))
# echo $(( num1 + num2 ))
# echo $(( num1 % num2 ))
# echo $( expr $num1 + $num2 )

# # Float point math using bc
# num1=20.5
# num2=5
# echo "20.5+5" | bc
# echo "20.5-5" | bc
# echo "20.5*5" | bc
# echo "20.5/5" | bc
# echo "scale=2;20.5/5" | bc
# echo "scale=2;$num1/$num2" | bc
# echo "scale=2;sqrt($num1)" | bc -l

# The case statement
# echo -e "Enter some character: \c"
# read vehicle
# case $vehicle in
# 	"car" )
# 		echo "Rent of $vehicle is 100 dollar" ;;
# 	"van" )
# 		echo "Rent of $vehicle is 80 dollar" ;;
# 	"truck" )
# 		echo "Rent of $vehicle is 150 dollar" ;;
# 	* )
# 		echo "unknown vehicle"
# esac

# # Array variables
# os=('utuntu' 'windows' 'kali')
# os[3]='mac'
# unset os[2]
# echo "${os[@]}"
# echo "${os[0]}"
# # print the index
# echo "${!os[@]}"

# # While loops
# # Using sleep to pause
# n=1
# # while [ $n -le 10 ]
# while (( $n <= 10 ))
# do
# 	echo "$n"
# 	# n=$(( n+1 ))
# 	(( ++n ))
# 	sleep 1 # Pause 1 sec
# done