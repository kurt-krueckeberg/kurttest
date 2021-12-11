#!/usr/bin/env rdmd
import std.exception;
import std.stdio;
import std.string;
import std.uni;
import std.regex;
import std.regex;
import std.range;

/*
 * In D, types 'char' and 'string' are both built-in types and bot are UTF-8 character-encoded characters. wchar is utf-16 and dchar is utf-32. 
 */

void main(string[] args)
{
   if (args.length != 3) {

      writeln("Enter the name of input file followed by the name of the output file.");
      return;
   }

   try {

      auto ifile = File(args[1], "r");
      auto ofile = File(args[2], "w");

      static auto pattern = ctRegex!(`^(der|die|das)\s([^(]+)\(-?([^)]+)\)(\s+:\s+.+)$`);

      foreach (line; ifile.byLine) {

          auto rmatch = matchFirst(line, pattern); 

          if (rmatch.length != 0)

              ofile.writeln(rmatch.captures[1]~" "~rmatch.captures[2] ~ ", die " ~  rmatch.captures[2] ~ rmatch.captures[3] ~ rmatch.captures[4]);

          else 

              ofile.writeln(line);
    }

   } catch ( ErrnoException e) { // FileException is unidentified.

      writeln(e.msg); 
      writeln(e.file); 
      writeln(e.line); 
       
   } finally {

   }
}
