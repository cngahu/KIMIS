<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KIHBT Medical Form</title>
    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000000;
        }

        .title-line {
            font-weight: bold;
            font-size: 13px;
        }

        .subtitle-line {
            font-size: 11px;
            font-style: italic;
        }

        .section-header {
            font-weight: bold;
            background-color: #00FFFF; /* cyan like original */
            padding: 2px 4px;
            border: 1px solid #000;
            font-size: 11px;
        }

        .label-strong {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000;
        }

        .no-border td,
        .no-border th {
            border: none;
        }

        .small-text {
            font-size: 10px;
        }

        .checkbox-cell {
            width: 18px;
        }

        .checkbox-box {
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            display: inline-block;
        }

        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .mt-20 { margin-top: 20px; }

        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }

        .signature-line {
            border-top: 1px solid #000;
            height: 18px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .part-label {
            font-weight: bold;
            font-size: 11px;
        }
    </style>
</head>
<body>

{{-- TOP TITLE --}}
<p class="title-line">FORM:  KIHBT/MED./020</p>
<p class="subtitle-line">
    MEDICAL REPORT ON THE APPLICANT FOR ADMISSION INTO A COURSE AT KIHBT.
</p>

<p class="small-text">
    <span class="label-strong">PART 1:</span>
    To be completed by the applicant who is responsible for answering each question as accurately as
    possible. <span class="label-strong">FAILURE TO DISCLOSE</span> medical history in full may lead to rejection of the
    applicant for admission to the course he/she has been offered.
</p>

{{-- CANDIDATE MEDICAL HISTORY HEADER --}}
<div class="section-header mt-5">
    CANDIDATE’S MEDICAL HISTORY (in block letters)
</div>

{{-- PART (A): NAME / ADDRESS / SEX / DOB --}}
<table class="table-bordered" style="margin-top: 3px;">
    <tr>
        <td style="width: 25%;" class="label-strong">(A) Your Full name</td>
        <td style="width: 55%;">&nbsp;</td>
        <td style="width: 10%;" class="label-strong text-center">Sex</td>
        <td style="width: 10%;">&nbsp;</td>
    </tr>
    <tr>
        <td class="label-strong">Permanent addresses</td>
        <td>&nbsp;</td>
        <td class="label-strong text-center">D.O.B</td>
        <td>___/___/______</td>
    </tr>
</table>

{{-- PART (B): LIST OF CONDITIONS --}}
<p class="mt-10 mb-5 part-label">
    (B) Have you had any of the following? (Answer: - Yes OR No.)
</p>

<table class="no-border" style="width: 100%;">
    <tr valign="top">
        {{-- COLUMN 1 --}}
        <td style="width: 33%;">
            <table class="no-border">
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Allergic disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Asthma</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Diabetes</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Dysentery</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>ENT disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Epilepsy</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Eye disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Gastric/Duodenal ulcer</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Gynecological disorder</td>
                </tr>
            </table>
        </td>

        {{-- COLUMN 2 --}}
        <td style="width: 33%;">
            <table class="no-border">
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Heart disease</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Jaundice</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Kidney disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Nervous Breakdown</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Neurological disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Operations</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Pleurisy</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Pneumonia</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Polio</td>
                </tr>
            </table>
        </td>

        {{-- COLUMN 3 --}}
        <td style="width: 34%;">
            <table class="no-border">
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Psychiatric disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Recurrent indigestion</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Rheumatic disorder</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Rupture</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Sickle cell disease</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Skin disease</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Tropical diseases or malaria</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Tuberculosis</td>
                </tr>
                <tr>
                    <td class="checkbox-cell"><span class="checkbox-box"></span></td>
                    <td>Varicose veins</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- PART (C): IF YES TABLE --}}
<p class="mt-10 mb-5 part-label">
    (C) <u>If any question above is Yes</u>, please give the following: -
</p>

<table class="table-bordered">
    <tr class="label-strong">
        <td style="width: 10%;">Year</td>
        <td style="width: 45%;">Treatment received</td>
        <td style="width: 45%;">Recurrences or lasting effects</td>
    </tr>
    <tr>
        <td style="height: 20px;">1.</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="height: 20px;">2.</td>
        <td></td>
        <td></td>
    </tr>
</table>

{{-- SIGNATURE OF APPLICANT --}}
<p class="mt-10 small-text">
    Signature of the applicant/candidate (to be signed in the presence of the examining doctor :)
</p>

<table class="table-bordered">
    <tr>
        <td style="width: 50%;">
            <span class="label-strong">Signature:</span>
            <div style="height: 18px;"></div>
        </td>
        <td style="width: 50%;">
            <span class="label-strong">Date:</span>
            <div style="height: 18px;"></div>
        </td>
    </tr>
</table>

{{-- PART 2 HEADER --}}
<p class="mt-15 section-header">
    PART 2&nbsp;&nbsp;&nbsp; Medical Examiner’s Report after the examination of the applicant.
</p>

{{-- PART 2 TABLE --}}
<table class="table-bordered" style="margin-top: 3px;">
    <tr>
        <td style="width: 25%;" class="label-strong">Doctor’s name:</td>
        <td style="width: 35%;"></td>
        <td style="width: 20%;" class="label-strong">Doctor’s signature:</td>
        <td style="width: 20%;"></td>
    </tr>
    <tr>
        <td class="label-strong">Doctor’s address:</td>
        <td></td>
        <td class="label-strong">Doctor’s telephone:</td>
        <td></td>
    </tr>
    <tr>
        <td class="label-strong">Name of medical institution:</td>
        <td></td>
        <td class="label-strong">Date candidate examined</td>
        <td></td>
    </tr>
</table>

{{-- BOTTOM STAMP + FOOTER TEXT --}}
<table class="no-border mt-15" style="width: 100%;">
    <tr>
        <td style="width: 40%;"><span class="label-strong">[STAMP]</span></td>
        <td style="width: 60%;" class="small-text text-right">
            This medical report will be filed in the student’s file.<br>
            A qualified Medical Practitioner should examine the student.<br>
            =Pg.3
        </td>
    </tr>
</table>

</body>
</html>
