using System;
using System.Collections;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace LollipopUI
{
    public partial class MainForm : Form
    {
        public MainForm()
        {
            InitializeComponent();

			Dictionary.LoadWordList("wordlist.txt");

			string temp = @"            Nếu bạn, đang !mong     muốn tiếp cận và tìm hiểu về các bài viết trên STDIO&nbsp;thì những thông tin sau đây có thể giúp bạn.

STDIO&nbsp;là hệ thống         ";

			temp = temp.Trim();
			temp = temp.ToLower();
			temp = temp.Replace("&nbsp;", " ");

			int x = 0;

		}

		private void browse_folder_raw_TextChanged(object sender, EventArgs e)
		{
			string directory = browse_folder_raw.Text;

			try
			{
				DirectoryInfo _directInfo = new DirectoryInfo(directory);
				FileInfo[] files = _directInfo.GetFiles();

				txtbox_input.Text = "";

				foreach (FileInfo file in files)
				{
					txtbox_input.Text += file.FullName + Environment.NewLine;
				}
			}
			catch
			{
				MessageBox.Show("Invalid folder. Please select a folder for tokenizing!!!");
			}
		}

		private void btn_tokenize_Click(object sender, EventArgs e)
		{
			if(txtbox_input.Text == "")
			{
				MessageBox.Show("Please select a folder for tokenizing!!!");
				return;
			}

			FolderBrowserDialog _dialog = new FolderBrowserDialog();
			string _outputDirectory = null;

			if (_dialog.ShowDialog() != DialogResult.OK)
				return;

			_outputDirectory = _dialog.SelectedPath.Replace("\r", String.Empty);
			string[] _lines = txtbox_input.Lines;

			try
			{
				foreach(string _line in _lines)
				{
					try
					{
						string _inputPath = _line.Replace("\r", String.Empty);
						var _readStream = new System.IO.FileStream(_inputPath,
										  System.IO.FileMode.Open,
										  System.IO.FileAccess.Read,
										  System.IO.FileShare.ReadWrite);
						var _reader = new System.IO.StreamReader(_readStream, System.Text.Encoding.UTF8, true, 128);

						string _id = _reader.ReadLine();
						string _friendly_url = _reader.ReadLine();
						string _title = _reader.ReadLine();
						string _tags = _reader.ReadLine();
						string _content = _reader.ReadToEnd();
						
						Tokenizer _tokenizer = new Tokenizer();
						ArrayList _result = _tokenizer.Tokenizing(_content);

						_reader.Dispose();
						_readStream.Dispose();



						string _outputPath = _outputDirectory + "\\" + _id + '-' + _friendly_url + ".tok";
						var _writetream = new System.IO.FileStream(_outputPath,
										  System.IO.FileMode.Create,
										  System.IO.FileAccess.Write,
										  System.IO.FileShare.ReadWrite);
						var _writer = new System.IO.StreamWriter(_writetream, System.Text.Encoding.UTF8, 128);
						_writer.Write(_id + Environment.NewLine + _friendly_url + Environment.NewLine +
										_title + Environment.NewLine + _tags + Environment.NewLine + string.Join("\n", _result));

						_writer.Dispose();
						_writetream.Dispose();

						txtbox_tokenized.Text += _outputPath + Environment.NewLine;
					}
					catch
					{

					}
				}
			}
			catch
			{
				MessageBox.Show("No file to tokenize. Process failed...");
			}
		}

		private void btn_indexing_Click(object sender, EventArgs e)
		{
			if (txtbox_tokenized.Text == "")
			{
				MessageBox.Show("Please select a folder for indexing!!!");
				return;
			}

			FolderBrowserDialog _dialog = new FolderBrowserDialog();
			string _outputDirectory = null;

			if (_dialog.ShowDialog() != DialogResult.OK)
				return;

			_outputDirectory = _dialog.SelectedPath.Replace("\r", String.Empty);
			string[] _lines = txtbox_tokenized.Lines;

			try
			{
				foreach (string _line in _lines)
				{
					try
					{
						string _inputPath = _line.Replace("\r", String.Empty);
						var _readStream = new System.IO.FileStream(_inputPath,
										  System.IO.FileMode.Open,
										  System.IO.FileAccess.Read,
										  System.IO.FileShare.ReadWrite);
						var _reader = new System.IO.StreamReader(_readStream, System.Text.Encoding.UTF8, true, 128);

						string _id = _reader.ReadLine();
						string _friendly_url = _reader.ReadLine();
						string _title = _reader.ReadLine();
						string _tags = _reader.ReadLine();
						ArrayList _wordsTokenized = new ArrayList();
						string _wordToken = null;

						while((_wordToken = _reader.ReadLine()) != null)
						{
							_wordsTokenized.Add(_wordToken);
						}

						Indexer _indexer = new Indexer();
						ArrayList _result = _indexer.Indexing(_title, _tags, _wordsTokenized);

						_reader.Dispose();
						_readStream.Dispose();



						string _outputPath = _outputDirectory + "\\" + _id + '-' + _friendly_url + ".ind";
						var _writetream = new System.IO.FileStream(_outputPath,
										  System.IO.FileMode.Create,
										  System.IO.FileAccess.Write,
										  System.IO.FileShare.ReadWrite);
						var _writer = new System.IO.StreamWriter(_writetream, System.Text.Encoding.UTF8, 128);
						_writer.Write(_id + Environment.NewLine + _friendly_url + Environment.NewLine + 
										_title + Environment.NewLine + _tags + Environment.NewLine);

						foreach(Word _word in _result)
						{
							_writer.WriteLine(_word.m_content + '|' + _word.m_weight);
						}

						_writer.Dispose();
						_writetream.Dispose();

						txtbox_indexed.Text += _outputPath + Environment.NewLine;
					}
					catch
					{

					}
				}
			}
			catch
			{
				MessageBox.Show("No file to tokenize. Process failed...");
			}
		}

		private void browse_folder_tokenized_TextChanged(object sender, EventArgs e)
		{
			string directory = browse_folder_tokenized.Text;

			try
			{
				DirectoryInfo _directInfo = new DirectoryInfo(directory);
				FileInfo[] files = _directInfo.GetFiles();

				txtbox_tokenized.Text = "";

				foreach (FileInfo file in files)
				{
					txtbox_tokenized.Text += file.FullName + Environment.NewLine;
				}
			}
			catch
			{
				MessageBox.Show("Invalid folder. Please select a folder for indexing!!!");
			}
		}
	}
}
