BEGIN:VCARD
VERSION:3.0
CLASS:PUBLIC
PRODID:-//class_vcard from TroyWolf.com//NONSGML Version 1//EN
REV:2008-09-17 20:55:39
FN:{$phoneRecord.FirstName} {$phoneRecord.LastName} {$phoneRecord.Suffix}
N:{$phoneRecord.LastName};{$phoneRecord.FirstName};;;{$phoneRecord.Suffix}
ORG:Liphp
ADR;TYPE=work:;{$phoneRecord.Address2};{$phoneRecord.Address};{$phoneRecord.City};{$phoneRecord.State};{$phoneRecord.Zip};USA
TEL;TYPE=work,voice:{$phoneRecord.OfficeNumber}
TEL;TYPE=cell,voice:{$phoneRecord.MobileNumber}
TEL;TYPE=home,voice:{$phoneRecord.HomeNumber}
TZ:-0500
END:VCARD

